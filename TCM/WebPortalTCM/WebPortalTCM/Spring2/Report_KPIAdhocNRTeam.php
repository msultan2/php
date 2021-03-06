<?php
	$startDate = '4/1/2013';
	$endDate = date('m/d/Y', time() + (60 * 60 * 24 * -1));
	//echo $weekback." ".$yesterday;

	if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $startDate;
	if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $endDate;
	
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
		$sql = "SELECT Support_Organization,count(*) CRQnum 
				FROM  dbo.vw_Change_Approval_Details
				WHERE CRQ_Type = 'Normal' AND Status NOT IN ('Request For Authorization','Cancelled','Rejected')
					AND ( dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom')
					AND dbo.DateOnly(Submit_Date) >= dbo.DateOnly(dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date,'Previous') )
				GROUP BY Support_Organization
				ORDER BY CRQnum DESC;";
		
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Support_Organization']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Team', 'Adhocs NR'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});       
		
		//drawPieChart
		var options = {           title: 'Adhoc Normal Changes'  , is3D: true  , chartArea:{left:20,top:20,width:"60%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 500px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 400px; height: 150px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>