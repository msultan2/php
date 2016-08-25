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
		$data_Val_Normal = array();
		$data_Date = array(); 	
		
			
		$m = $ini_array['NUM_OF_MONTHS'] - 1; //7;
		for ($i=0; $i < $ini_array['NUM_OF_MONTHS']; $i++) {
			$sql_old = "SELECT YEAR(Scheduled_Start_Date) Scheduled_year,MONTH(Scheduled_Start_Date) AS Scheduled_month,isnull(count(*),0) CRQnum
				FROM  dbo.vw_Change_Approval_Details cap
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
					AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))
				AND Status NOT IN ('Draft', 'Request For Authorization')
				AND CRQ_Type = 'Normal'
				AND [First Approval Date] IS NOT NULL
				AND ( (DATEPART(hour, [First Approval Date]) > '14'
											AND dbo.DATEONLY( [First Approval Date]) >= (dbo.DATEONLY( Scheduled_Start_Date) -1) ) 
										OR	Emergency = 0	 )	  
				GROUP BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date)
				ORDER BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date);";
			$sql = "SELECT YEAR(Scheduled_Start_Date) Scheduled_year,MONTH(Scheduled_Start_Date) AS Scheduled_month,isnull(count(*),0) CRQnum
				FROM  dbo.vw_Change_Approval_Details cap
				WHERE dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
					AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))
				AND Status NOT IN ('Draft', 'Request For Authorization')
				AND CRQ_Type = 'Normal'
				AND [First Approval Date] IS NOT NULL
				AND ( (DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM'
						AND dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(Scheduled_Start_Date, 'Previous'))   )
					OR	Emergency = 0 ) 
				GROUP BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date)
				ORDER BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date);";
			$stmt = sqlsrv_query( $conn, $sql );
			//echo $sql;
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				//array_push($data_Val_Emergency,$row['CRQnum']);
				$year = $row['Scheduled_year'];
				$month = $row['Scheduled_month'];
				$numof_CRQs = $row['CRQnum'];
				
				$data_month = date("F", mktime(0, 0, 0, $month, 10));
								//date("F Y", strtotime("-$m month"));
				//$data_Date[$i] = substr($data_month,0,3).' '.substr($data_month,-4);
				$data_Date[$i] = substr($data_month,0,3).' '.$year;
				$my_month = $data_Date[$i]; //$data_month;
				if ( is_numeric($numof_CRQs) ) $data_Val_Emergency[$my_month] = $numof_CRQs;
				else $data_Val_Emergency[$my_month] = 0;
				if ( $numof_CRQs == '') $data_Val_Emergency[$my_month] = 0;
				//$data_Date[$i] = $data_month;
				//echo $data_Date[$i]." - ";
			}
			sqlsrv_free_stmt( $stmt);
			
			$m = $m -1;
		}
		
		
		//Normal
		$m = $ini_array['NUM_OF_MONTHS'] - 1; //7;
		for ($i=0; $i < $ini_array['NUM_OF_MONTHS']; $i++) {
			$sql = "SELECT YEAR(Scheduled_Start_Date) Scheduled_year,MONTH(Scheduled_Start_Date) AS Scheduled_month,isnull(count(*),0) CRQnum
				FROM dbo.vw_change_approval_details ch
				WHERE CRQ_Type = 'Normal'
				AND [First Approval Date] IS NOT NULL
				AND dbo.dateOnly(Scheduled_Start_Date) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
					AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))
				AND STATUS NOT IN ('Draft','Request For Authorization')
				--AND (DATEPART(wk,ch.Scheduled_Start_Date) <= DATEPART(wk,getdate()) OR DATEPART(year,ch.Scheduled_Start_Date) < DATEPART(year,getdate()))
				GROUP BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date)
				ORDER BY YEAR(Scheduled_Start_Date),MONTH(Scheduled_Start_Date);";
			$stmt = sqlsrv_query( $conn, $sql );
			//echo $sql;
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$year = $row['Scheduled_year'];
				$month = $row['Scheduled_month'];
				$numof_CRQs = $row['CRQnum'];
				
				//$data_month = date("F Y", strtotime("-$m month"));
				$data_month = date("F", mktime(0, 0, 0, $month, 10));
				$my_month = substr($data_month,0,3).' '.$year;
				if ( is_numeric($numof_CRQs) ) $data_Val_Normal[$my_month] = $numof_CRQs;
				else $data_Val_Normal[$my_month] = 0;
				if ( $numof_CRQs == '') $data_Val_Normal[$my_month] = 0;
			
			}
			sqlsrv_free_stmt( $stmt);
						
			$m = $m -1;
		}
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([           
			['Month of Year','Exceptions'],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					if ($i==count($data_Date)-1) break;		//ignore current month
					echo "['".$month."',".$data_Val_Emergency[$month]."]";
					if ($i<count($data_Date)-2) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
		var dataChart_temp = google.visualization.arrayToDataTable([           
			['Month of Year','Exception Percent'],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					//if ($i==count($data_Date)-1) break;		//ignore current month
					if ($i<count($data_Date)-6 OR $i==(count($data_Date)-1)){ $i++; continue;	}	//ignore before April 2013
					echo "['".$month."',".round(($data_Val_Emergency[$month] / $data_Val_Normal[$month])*100)." ]";
					if ($i<count($data_Date)-2) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
		
		var dataTable = google.visualization.arrayToDataTable([     
			['Month of Year', 'Normal Changes','Exception Changes','Exceptions %','Normal Total'],      
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {      
					echo "['".$month."',".($data_Val_Normal[$month] - $data_Val_Emergency[$month]).",".$data_Val_Emergency[$month].",'".round(($data_Val_Emergency[$month] / $data_Val_Normal[$month])*100)." \%',".$data_Val_Normal[$month]."]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
					
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Monthly Exceptions Trend'  ,  chartArea:{left:40,top:40,width:"75%",height:"70%"}, colors:['darkred'],vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Monthly Exceptions Trend', titleTextStyle: {color: 'red'}, gridlines:{count:6}, slantedText:true}   };          
		var options_temp = { title: 'Monthly Authorized Changes Trend'  ,  chartArea:{left:40,top:40,width:"75%",height:"70%"},vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Percentage of Emergency Changes', titleTextStyle: {color: 'red'}, gridlines:{count:6}, slantedText:true}   };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart_temp, options_temp);       
		//chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





