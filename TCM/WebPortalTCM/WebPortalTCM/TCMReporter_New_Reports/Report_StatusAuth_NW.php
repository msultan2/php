<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php // content="text/plain; charset=utf-8"

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
		$array_totals = array(); 
		$data_Val = array(); 
		$data_Date = array(); 		
		$array_month_total = array();
		//$array_status = array('Request For Authorization', 'Scheduled','Rejected','Cancelled','Completed','Closed');
		
		//foreach ($array_status as &$status) {
		//	$data_Val[$status] = array();
		//	$array_totals[$status] = 0;
		//	$m = $ini_array['NUM_OF_MONTHS'] - 1; //7;
		//	for ($i=0; $i < $ini_array['NUM_OF_MONTHS']; $i++) {
		
		$sql = "SELECT chMonth,chYear,Authorized, Unauthorized,Cancelled, Rejected
						FROM (
						SELECT YEAR(cap.Scheduled_Start_Date) chYear,MONTH(cap.Scheduled_Start_Date) AS chMonth,
								CASE Status WHEN 'Scheduled' THEN 'Authorized'
											WHEN 'Implementation In Progress' THEN 'Authorized'
											WHEN 'Completed' THEN 'Authorized'
											WHEN 'Closed' THEN 'Authorized' 
											WHEN 'Request For Authorization' THEN 'Unauthorized'
											WHEN 'Rejected' THEN 'Rejected'
											WHEN 'Cancelled' THEN 'Cancelled' 
											  ELSE Status
											END chStatus,count(*) CRQnum
											FROM  dbo.vw_Change_Approval_Details cap
											WHERE 
											ChangeFor = 'Network'
											AND cap.Scheduled_Start_Date <= getdate()
											AND cap.CRQ_Type = 'Normal'
											GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),
									CASE Status WHEN 'Scheduled' THEN 'Authorized'
										WHEN 'Implementation In Progress' THEN 'Authorized'
										WHEN 'Completed' THEN 'Authorized'
										WHEN 'Closed' THEN 'Authorized' 
										WHEN 'Request For Authorization' THEN 'Unauthorized'
										WHEN 'Rejected' THEN 'Rejected'
										WHEN 'Cancelled' THEN 'Cancelled' 											
										ELSE Status
											  END
									  ) queryA
											PIVOT 
												( max(CRQnum)
													for chStatus in ([Authorized],[Unauthorized],[Cancelled],[Rejected])
												) queryP 
											ORDER BY chYear,chMonth ;";
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		for ($i=0;$i<=4;$i++)
			$data_Desc[$i] = array();
		
		//$data_Val = array();
		$data_Month = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc[0],$row['Authorized']);
			array_push($data_Desc[1],$row['Unauthorized']);
			array_push($data_Desc[2],$row['Cancelled']);
			array_push($data_Desc[3],$row['Rejected']);
			array_push($data_Month,$row['chMonth']." ".$row['chYear']);
		}
					
				
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
			
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([           
			/*	['Month', 'team1', 'team2','team3',..,'team10'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month',  'Authorized','Unauthorized','Cancelled','Rejected'],         
			<?php 
				$i=0;
				foreach ($data_Month as &$month) {             
					echo "['".$month."',".$data_Desc[0][$i].",".$data_Desc[1][$i].",".$data_Desc[2][$i].",".$data_Desc[3][$i]."]"; 
					if ($i<count($data_Month)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			 ] ); 
			 
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataChart, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Trend of NW CRQs Status'  ,  chartArea:{left:40,top:20,width:"70%",height:"80%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Normal Changes Per Status over time', titleTextStyle: {color: 'red'},  gridlines:{count:6}, slantedText:true}   };          
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td" width="650px" height="400px"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>





