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
		// get IT & NW CRQs Normal from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days
		// AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE CRQ_Type = 'Normal'
				AND Status NOT IN ('Request For Authorization','Pending','Cancelled','Rejected')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val_NR = array();
		$data_Val_ST = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val_NR,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		
		// get IT & NW CRQs Standard from today till last week (ex: from yesterday Wednesday till last Thursday) 7 days,'Cancelled')
		$sql = "SELECT CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END ChangeFor,count(*) CRQnum FROM dbo.vw_Change_Approval_Details ch
				WHERE CRQ_Type = 'Standard'
				AND Status NOT IN ('Request For Authorization','Pending','Cancelled','Rejected')
				AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				GROUP BY CASE WHEN ".$ini_array['IT_CONDITION']." THEN 'IT' ELSE 'NETWORK' END  
				ORDER BY ChangeFor DESC;";

		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//array_push($data_Desc,$row['ChangeFor']);
			array_push($data_Val_ST,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Changes For', 'Standard Changes','Non-Standard Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val_ST[$i].",".$data_Val_NR[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>	] );       
		var options = {           title: 'CRQs Authorized per Domain'  , is3D: true  , chartArea:{left:40,top:30,width:"60%",height:"80%"} , 'isStacked':true, selectionMode:'multiple',
									colors:['royalblue','green'] };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td class="iframe_td"><div id="chart_div" style="width: 350px; height: 300px;"></div>  </td>
		<tr><td> <a href="Reporter_TCM_Weekly2.php" style="margin-left: 20px" target="_blank">More..</a></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>