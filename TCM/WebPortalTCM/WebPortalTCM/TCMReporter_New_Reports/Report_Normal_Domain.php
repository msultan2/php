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
		$array_category = array('Core','Fixed','IT','Radio','Services',);
		
		foreach ($array_category as &$category) {
			$data_Val[$category] = array();
			$array_totals[$category] = 0;
			$m = $ini_array['NUM_OF_MONTHS'] -1; //-1 to add current month;
			for ($i=0; $i < $ini_array['NUM_OF_MONTHS']; $i++) {
				$sql = "SELECT YEAR(ch.Scheduled_Start_Date) Scheduled_year,MONTH(ch.Scheduled_Start_Date) AS Scheduled_month,
								CASE  WHEN Support_Group_Name IN ('Post-Paid Charging','Data & Innovation','Online Enterprise') THEN 'IT' 
										WHEN Support_Group_Name = 'Mobile Internet & Data Support' THEN 'Services' 
										WHEN Support_Group_Name IN ('Fixed Transmission','Fixed Core Configuration') THEN 'Fixed'
										WHEN support_organization IN ('CRM & Sales','Customer Management Systems','Business Intelligence') THEN 'IT' 
										WHEN support_organization IN ('Charging & Mediation','Charging IN & Mediation','Network Information') THEN 'Services'
										WHEN support_organization = 'Mobile Internet & Enterprise' THEN 'Fixed'
										WHEN support_company = 'IT Operations' THEN 'IT'
										WHEN support_company IN ('Network Engineering','Service Management') THEN 'Core'
										WHEN support_company  = 'Regional Operations' THEN 'Radio'
										ELSE 'Services' END Domain,isnull(count(*),0) CRQnum
							FROM dbo.vw_change_approval_details ch
							WHERE STATUS NOT IN ('Draft','Request For Authorization')
									AND Support_Company IN ('Network Engineering','Service Management','Regional Operations','IT Operations','Products & Services Delivery')
									AND CRQ_Type = 'Normal'
									AND dbo.dateOnly(ch.Scheduled_Start_Date) BETWEEN dbo.dateOnly(DATEADD(month,-$m,getdate()-(DATEPART(d,getdate()) - 1)))
									AND DATEADD(second,-1,dbo.dateOnly(DATEADD(month,-$m+1,getdate()-(DATEPART(d,getdate()) - 1))))  
							GROUP BY YEAR(ch.Scheduled_Start_Date),MONTH(ch.Scheduled_Start_Date),
										CASE WHEN Support_Group_Name IN ('Post-Paid Charging','Data & Innovation','Online Enterprise') THEN 'IT' 
										WHEN Support_Group_Name = 'Mobile Internet & Data Support' THEN 'Services'                     
										WHEN Support_Group_Name IN ('Fixed Transmission','Fixed Core Configuration') THEN 'Fixed'
										WHEN support_organization IN ('CRM & Sales','Customer Management Systems','Business Intelligence') THEN 'IT' 
										WHEN support_organization IN ('Charging & Mediation','Charging IN & Mediation','Network Information') THEN 'Services'
										WHEN support_organization = 'Mobile Internet & Enterprise' THEN 'Fixed'
										WHEN support_company = 'IT Operations' THEN 'IT'
										WHEN support_company IN ('Network Engineering','Service Management') THEN 'Core'
										WHEN support_company  = 'Regional Operations' THEN 'Radio'
										ELSE 'Services' END
							ORDER BY 3;";
					
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					//echo $row['Domain'].' '.$category.'--';
					if($row['Domain']==$category){
						$year = $row['Scheduled_year'];
						$month = $row['Scheduled_month'];
						$numof_CRQs = $row['CRQnum'];
						//$month = date("F", mktime(0, 0, 0, $month, 10))." ".$year;
						$data_month = substr(date("F", strtotime("-$m month")),0,3).' '.date("Y", strtotime("-$m month"));
						if ( is_numeric($numof_CRQs) ) $data_Val[$category][$data_month] = $numof_CRQs;
						else $data_Val[$category][$data_month] = 0;
						//echo $numof_CRQs.' '.$data_month.'--'.$data_Val[$category][$data_month].'; ';
						$data_Date[$i] = $data_month;
						$array_totals[$category] += $data_Val[$category][$data_month];
						$array_month_total[$data_month] += $data_Val[$category][$data_month];
						//if ($i==0 )echo "data[$category][$data_month]=".$data_Val[$category][$data_month] ;
					}
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
		var dataChart= google.visualization.arrayToDataTable([  
			['Month',  
			<?php	for($i=0;$i<count($array_category); $i++) {             
						echo "'".$array_category[$i]."'";
						if ($i<count($array_category)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_category as &$category) {            
						echo $data_Val[$category][$month]; 
						if ($j<count($array_category)-1) echo ",";
						$j=$j+1;
					}
					echo "]";
					if ($i<count($data_Date)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			 ] );	
	var dataTable = google.visualization.arrayToDataTable([  
			['Month',  
			<?php	for($i=0;$i<count($array_category); $i++) {             
						echo "'".$array_category[$i]."'";
						if ($i<count($array_category)-1) echo ",";	//add ',' to all except last element
						else echo ",'Total'";
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_category as &$category) {            
						echo $data_Val[$category][$month]; 
						if ($j<count($array_category)-1) echo ",";
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
		var options = { title: 'Trend of Normal Changes per Domain'  ,  chartArea:{left:40,top:40,width:"80%",height:"75%"}, vAxis: {gridlines:{count:6}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Normal Changes over time', titleTextStyle: {color: 'red'},  gridlines:{count:6}} 
						//remove next 2 lines to remove Combo settings
						,seriesType: "bars",    
						series: { 5:{type: "area",color:"gray"}} };          
		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td class="iframe_td" width="900px" height="400px"><div id="chart_div" style="width: 900px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" style="width: 900px;"></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





