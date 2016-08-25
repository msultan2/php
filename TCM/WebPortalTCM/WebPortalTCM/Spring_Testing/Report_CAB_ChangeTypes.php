<?php
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
		$sql_old = "SELECT CRQ_TYPE,count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE dbo.dateonly(Scheduled_Start_Date) >= DATEADD(day, DATEDIFF(day, 0, CURRENT_TIMESTAMP),'2:00PM') -- today at 2:00PM
				AND dbo.dateonly(Scheduled_Start_Date) <  DATEADD(day, DATEDIFF(day, 0, GETDATE()), 2) -- before after-tomorrow
				GROUP BY CRQ_TYPE ORDER BY CRQnum DESC;";
		
		$sql = "SELECT 'Normal' CRQ_TYPE,count(DISTINCT CRQ) CRQnum 
				FROM dbo.vw_Change_Daily_CAB cab
				 UNION     
					  SELECT CRQ_TYPE,count(*) CRQnum 
					  FROM dbo.vw_Change_Approval_Details  ch LEFT OUTER JOIN dbo.tbl_Change_Task_Merged tsk
					  ON ch.CRQ = tsk.Request_ID 
								WHERE Status NOT IN ('Draft','Cancelled') AND ch.CRQ_Type = 'Standard'
					  AND ( [First Approval Date] < DATEADD(day, DATEDIFF(day, 0, CURRENT_TIMESTAMP),'2:11PM') -- today at 2:00PM
						OR  dbo.dateonly([First Approval Date]) < dbo.dateonly(getdate()) -- approved before today
						OR  [First Approval Date] IS NULL) 
					  AND ch.Scheduled_Start_Date >= DATEADD(day, DATEDIFF(day, 0, CURRENT_TIMESTAMP),'2:00PM') -- today at 2:00PM
					  AND dbo.dateonly(ch.Scheduled_Start_Date) <=  DATEADD(day, DATEDIFF(day, 0, dbo.udf_GetPrevNextWorkDay(CURRENT_TIMESTAMP,'Next')),'2:00PM') -- before next working day 2:00PM
								GROUP BY CRQ_TYPE ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$Total = 0;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['CRQ_TYPE']);
			array_push($data_Val,$row['CRQnum']);
			$Total += $row['CRQnum'];
		}
		array_push($data_Desc,'Total');
		array_push($data_Val,$Total);
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeTypes);  
	
	function draw_ChangeTypes() {         
		var dataChart = google.visualization.arrayToDataTable([           
			['Type of Changes', 'Number of Changes'],           
			<?php for($i=0;$i<count($data_Desc)-1; $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-2) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
		
		var data = google.visualization.arrayToDataTable([           
			['Type of Changes', 'Number of Changes'],           
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
		var options = {           title: 'Types of Changes'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 320px; height: 100px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>