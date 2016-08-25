<link href="style_new.css" rel="stylesheet" type="text/css" />
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
		$sql0 = "SELECT datepart(MONTH,ch.[First Approval Date]) appMonth,datepart(YEAR,ch.[First Approval Date]) appYear,
				  CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 'Before 2:00 PM'
					  WHEN datepart(HOUR,ch.[First Approval Date]) = 14 THEN '2:00 - 3:00'
					  WHEN datepart(HOUR,ch.[First Approval Date]) = 15 THEN '3:00 - 4:00'
					  WHEN datepart(HOUR,ch.[First Approval Date]) = 16 THEN '4:00 - 5:00'
					  WHEN datepart(HOUR,ch.[First Approval Date]) >= 17 THEN 'After 5:00 PM'
				  END hourInterval, CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 1 ELSE 2 END orderList, count(*) CRQnum
							FROM dbo.vw_Change_Approval_Details ch 
							WHERE CRQ_Type = 'Normal'
							AND [First On Behalf of] NOT IN ('Hraslan','CM_Eval')
							GROUP BY  datepart(MONTH,ch.[First Approval Date]),datepart(YEAR,ch.[First Approval Date]),
							  CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 'Before 2:00 PM'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 14 THEN '2:00 - 3:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 15 THEN '3:00 - 4:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 16 THEN '4:00 - 5:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) >= 17 THEN 'After 5:00 PM'
							 END, CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 1 ELSE 2 END
				ORDER BY  datepart(YEAR,ch.[First Approval Date]),datepart(MONTH,ch.[First Approval Date]),orderList ;	";
		
		$sql = "SELECT appMonth, appYear,[Before 2:00 PM] 'Before2:00',[2:00 - 3:00] '2:00-3:00',[3:00 - 4:00] '3:00-4:00',[4:00 - 5:00] '4:00-5:00',[After 5:00 PM] 'After5:00'
				  FROM (
				  SELECT datepart(MONTH,ch.[First Approval Date]) appMonth,datepart(YEAR,ch.[First Approval Date]) appYear,
				  CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 'Before 2:00 PM'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 14 THEN '2:00 - 3:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 15 THEN '3:00 - 4:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 16 THEN '4:00 - 5:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) >= 17 THEN 'After 5:00 PM'
				  END hourInterval, count(*) CRQnum
							FROM dbo.vw_Change_Approval_Details ch 
							WHERE CRQ_Type = 'Normal'
							AND ch.Status <> 'Request For Authorization'
							AND [First Approval Date] IS NOT NULL
							--AND [First On Behalf of] NOT IN ('Hraslan','CM_Eval')
							--AND dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))
							GROUP BY datepart(MONTH,ch.[First Approval Date]) ,datepart(YEAR,ch.[First Approval Date]) ,
				  CASE WHEN datepart(HOUR,ch.[First Approval Date]) < 14 THEN 'Before 2:00 PM'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 14 THEN '2:00 - 3:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 15 THEN '3:00 - 4:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) = 16 THEN '4:00 - 5:00'
								 WHEN datepart(HOUR,ch.[First Approval Date]) >= 17 THEN 'After 5:00 PM'
				  END 
					) queryA
					PIVOT 
						( max(CRQnum)
							for hourInterval in ([Before 2:00 PM],[2:00 - 3:00],[3:00 - 4:00],[4:00 - 5:00],[After 5:00 PM])
						) queryP ";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		for ($i=0;$i<=4;$i++)
			$data_Desc[$i] = array();
		//$data_Val = array();
		$data_month = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc[0],$row['Before2:00']);
			array_push($data_Desc[1],$row['2:00-3:00']);
			array_push($data_Desc[2],$row['3:00-4:00']);
			array_push($data_Desc[3],$row['4:00-5:00']);
			array_push($data_Desc[4],$row['After5:00']);
			array_push($data_month,$row['appMonth'].' '.$row['appYear']);
			//array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Month', 'Before 2:00 PM', '2:00 - 3:00','3:00 - 4:00','4:00 - 5:00','After 5:00 PM','Total'],           
			<?php 
				for($i=0;$i<count($data_month); $i++) {             
						echo "['".$data_month[$i]."',".$data_Desc[0][$i].",".$data_Desc[1][$i].",".$data_Desc[2][$i].",".$data_Desc[3][$i].",".$data_Desc[4][$i].",".
						($data_Desc[0][$i]+$data_Desc[1][$i] +$data_Desc[2][$i]+$data_Desc[3][$i] + $data_Desc[4][$i])."]"; 
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		var dataChart = google.visualization.arrayToDataTable([   
			['Month', 'Before 2:00 PM','2:00 - 3:00','3:00 - 4:00','4:00 - 5:00','After 5:00 PM'],           
			<?php 
				for($i=0;$i<count($data_month); $i++) {             
						echo "['".$data_month[$i]."',".$data_Desc[0][$i].",".$data_Desc[1][$i].",".$data_Desc[2][$i].",".$data_Desc[3][$i].",".$data_Desc[4][$i]."]"; 
						if ($i<count($data_month)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Monthly Trend of Approvals for Normal Changes'  ,  chartArea:{left:40,top:40,bottom:120,width:"75%",height:"70%"}, 
						slantedText: true, //colors:['darkgreen'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'First Approval of Requesters Managers', titleTextStyle: {color: 'red'}, gridlines:{count:7}}  };          
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 750px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>