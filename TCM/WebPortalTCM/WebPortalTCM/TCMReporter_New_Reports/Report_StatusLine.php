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
		$array_status = array('Request For Authorization', 'Scheduled','Rejected','Cancelled','Completed','Closed');
		
		foreach ($array_status as &$status) {
			$data_Val[$status] = array();
			$array_totals[$status] = 0;
			$m = $ini_array['NUM_OF_MONTHS'] - 1; //7;
			for ($i=0; $i < $ini_array['NUM_OF_MONTHS']; $i++) {
				$sql = "SELECT YEAR(cap.Scheduled_Start_Date) Scheduled_year,MONTH(cap.Scheduled_Start_Date) AS Scheduled_month,Status ,count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE Status = '$status'
					AND cap.Status NOT IN ('Draft')
					AND dbo.dateOnly(cap.Scheduled_Start_Date) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
					AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))  
					AND cap.CRQ_Type = 'Normal'
					GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),Status
					ORDER BY YEAR(cap.Scheduled_Start_Date) DESC,MONTH(cap.Scheduled_Start_Date) DESC,Status;";
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				if (sqlsrv_fetch($stmt)=== false){
					$numof_CRQs = 0;
				}	
				else{
					$year = sqlsrv_get_field( $stmt, 0);
					$month = sqlsrv_get_field( $stmt, 1);
					$numof_CRQs = sqlsrv_get_field( $stmt, 3);
					//$$month = date("F", mktime(0, 0, 0, $month, 10))." ".$year;
					$data_month = substr(date("F", strtotime("-$m month")),0,3).' '.date("Y", strtotime("-$m month"));
					if ( is_numeric($numof_CRQs) ) $data_Val[$status][$data_month] = $numof_CRQs;
					else $data_Val[$status][$data_month] = 0;
					$data_Date[$i] = $data_month;
					$array_totals[$status] += $data_Val[$status][$data_month];
					$array_month_total[$data_month] += $data_Val[$status][$data_month];
					//if ($i==0 )echo "data[$status][$data_month]=".$data_Val[$status][$data_month] ;
				}
				sqlsrv_free_stmt( $stmt);
				
				$m = $m -1;
			}
			
			
		}
		
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
			['Month',  
			<?php	for($i=0;$i<count($array_status); $i++) {             
						echo "'".$array_status[$i]."'";
						if ($i<count($array_status)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_status as &$status) {            
						echo $data_Val[$status][$month]; 
						if ($j<count($array_status)-1) echo ",";	
						$j=$j+1;
					}
					echo "]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			 ] ); 
					
	var dataTable0 = google.visualization.arrayToDataTable([           
			/*	['Month', 'team1', 'team2','team3',..,'team10'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month',  
			<?php	for($i=0;$i<count($array_status); $i++) {             
						echo "'".$array_status[$i]."'";
						if ($i<count($array_status)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_status as &$status) {            
						echo $data_Val[$status][$month]; 
						if ($j<count($array_status)-1) echo ",";	
						$j=$j+1;
					}
					echo "]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			,['Totals', 
			<?php
				$i=0;
				foreach ($array_status as &$status) {                  
					echo $array_totals[$status];
					if ($i<count($array_status)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
				echo "]";
			?>
			 ] );
	var dataTable = google.visualization.arrayToDataTable([           
			/*	['Month', 'team1', 'team2','team3',..,'team10'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month',  
			<?php	for($i=0;$i<count($array_status); $i++) {             
						echo "'".$array_status[$i]."'";
						if ($i<count($array_status)-1) echo ",";	//add ',' to all except last element
						else echo ",'Total'";
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_status as &$status) {            
						echo $data_Val[$status][$month]; 
						if ($j<count($array_status)-1) echo ",";
						else echo ",".$array_month_total[$month];
						$j=$j+1;
					}
					echo "]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			 ] );			 
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Trend of CRQs Status'  ,  chartArea:{left:40,top:20,width:"70%",height:"80%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Normal Changes Per Status over time', titleTextStyle: {color: 'red'},  gridlines:{count:6}}   };          
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td" width="650px" height="400px"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





