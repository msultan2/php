<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php

	$weekback = date('m/d/Y', time() + (60 * 60 * 24 * -7));
	$yesterday = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $weekback;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $yesterday;
	
	/* Parse configuration file */
	$ini_array = parse_ini_file("config.ini");
	
	/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'],
								"PWD"=>$ini_array['DB_PASS'],
								"Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$data_Desc = array();
		$data_Val_NR = array();
		$data_Val_ST = array();
		
		// get Authorization status of CRQs Normal & Standard from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		$sql = "SELECT chStatus, chOrder,[Normal], [Standard]
				FROM (
					SELECT CRQ_Type chType,CASE Status WHEN 'Scheduled' THEN 'Fully Approved'
						WHEN 'Completed' THEN 'Fully Approved'
						WHEN 'Closed' THEN 'Fully Approved' 
						WHEN 'Implementation In Progress' THEN 'Fully Approved'
						WHEN 'Request For Authorization' THEN 'Pending Approval'
						WHEN 'Rejected' THEN 'Rejected'
						WHEN 'Cancelled' THEN 'Cancelled' 
						ELSE Status
						END chStatus,
            CASE Status WHEN 'Scheduled' THEN 1
            WHEN 'Completed' THEN 1
						WHEN 'Closed' THEN 1 
						WHEN 'Implementation In Progress' THEN 1
						WHEN 'Request For Authorization' THEN 2
						WHEN 'Rejected' THEN 4
						WHEN 'Cancelled' THEN 3 
            ELSE 5
            END chOrder
            ,count(*) CRQnum
				FROM  dbo.vw_Change_Approval_Details cap
				WHERE  dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'           
				GROUP BY CRQ_Type,CASE Status WHEN 'Scheduled' THEN 'Fully Approved'
						WHEN 'Completed' THEN 'Fully Approved'
						WHEN 'Closed' THEN 'Fully Approved' 
						WHEN 'Implementation In Progress' THEN 'Fully Approved'
						WHEN 'Request For Authorization' THEN 'Pending Approval'
						WHEN 'Rejected' THEN 'Rejected'
						WHEN 'Cancelled' THEN 'Cancelled' 											
						ELSE Status
						END,
            CASE Status WHEN 'Scheduled' THEN 1
            WHEN 'Completed' THEN 1
						WHEN 'Closed' THEN 1 
						WHEN 'Implementation In Progress' THEN 1
						WHEN 'Request For Authorization' THEN 2
						WHEN 'Rejected' THEN 4
						WHEN 'Cancelled' THEN 3 
            ELSE 5
            END 
            ) queryA
					PIVOT 
						( max(CRQnum)
							for chType in ([Normal],[Standard])
						) queryP 
						ORDER BY chOrder;";

		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['chStatus']);
			array_push($data_Val_NR,$row['Normal']);
			array_push($data_Val_ST,$row['Standard']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Status', 'Standard Changes','Non-Standard Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val_ST[$i].",".$data_Val_NR[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  
			?>	] );       
		var options = { title: 'NW CRQs Authorization Status' , hAxis:{slantedText:true} , chartArea:{left:40,top:30,width:"60%",height:"70%"} , 'isStacked':true, colors:['royalblue','green'] };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 350px; height: 300px;"></div>  </td></tr>
		<tr><td> <a href="Reporter_Status.php" style="margin-left: 20px" target="_blank">More..</a></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>