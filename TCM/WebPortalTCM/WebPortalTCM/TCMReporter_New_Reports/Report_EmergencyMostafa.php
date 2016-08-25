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
		$data_Val_Emergency = array();
		$MM_YY = array();
		
			
			$sql = "Select 
			 Count(*) Num_of_Emergncy, CAST(Month(Scheduled_Start_Date) AS VARCHAR)+' '+CAST(Year(Scheduled_Start_Date) AS VARCHAR)Sara
			From 
			 dbo.tbl_Change_Approval_Details
			Where
			 Emergency=0 and Year(Scheduled_Start_Date) = 2012
			Group by 
			Month(Scheduled_Start_Date),Year(Scheduled_Start_Date)
			Order by Year(Scheduled_Start_Date),Month(Scheduled_Start_Date) Asc;";
			$stmt = sqlsrv_query( $conn, $sql );
			echo $sql;
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				array_push($MM_YY,$row['Sara']);
				$numof_CRQs = $row['Num_of_Emergncy'];
				
				echo $row['Sara'].": ".$numof_CRQs;
				 $data_Val_Emergency[$row['Sara']] = $numof_CRQs;
				 echo "--> ".$data_Val_Emergency[$row['Sara']];
			}
			sqlsrv_free_stmt( $stmt);
			
		
		
		
		
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([           
			['Month of Year','Exception Emergencies '],
			<?php 
				$i=0;
				foreach ($MM_YY as &$month) {             
					echo "['".$month."',".$data_Val_Emergency[$month]."]";
					if ($i<count($MM_YY)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
    
		
		//drawPieChart
		var options = { title: 'SARA'  ,  chartArea:{left:40,top:40,width:"75%",height:"70%"}, colors:['black'],vAxis: {gridlines:{count:20}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Monthly Exceptions Trend', titleTextStyle: {color: 'red'}, gridlines:{count:20}, slantedText:false}   };          
		        
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		//chart.draw(dataChart_temp, options_temp);       
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





