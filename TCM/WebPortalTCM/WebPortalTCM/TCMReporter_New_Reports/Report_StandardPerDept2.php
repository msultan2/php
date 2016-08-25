<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php // content="text/plain; charset=utf-8"

$array_depts = array("Network Engineering","Products & Services Delivery","Regional Operations","Service Management","IT Operations");

/* Specify the server and connection string attributes. */
		$serverName = "egoct-wirws01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$data_Desc = array(); 
		$data_Val = array(); 
		$data_Date = array(); 		
		
		
			//$data_Val = array(); 
		foreach ($array_depts as &$dept) {
			$data_Val[$dept] = array();
				$sql = "SELECT YEAR(cap.Scheduled_Start_Date) Scheduled_year,MONTH(cap.Scheduled_Start_Date) AS Scheduled_month,cap.Support_Company, count(*) CRQnum
						FROM  dbo.vw_Change_Approval_Details cap
						WHERE cap.Support_Company = '".$dept."'
						AND dbo.dateOnly(Scheduled_Start_Date) BETWEEN DATEADD(month,-4,getdate())
						AND   DATEADD(month,-1,getdate())
						AND cap.Status NOT IN ('Draft', 'Request For Authorization')
						AND cap.CRQ_Type = 'Normal'
						GROUP BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date),cap.Support_Company
						ORDER BY YEAR(cap.Scheduled_Start_Date),MONTH(cap.Scheduled_Start_Date);";
				$stmt = sqlsrv_query( $conn, $sql );
				//echo $sql;
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				if (sqlsrv_fetch($stmt)=== false){
					die( print_r( sqlsrv_errors(), true));
				}	 
				$year = sqlsrv_get_field( $stmt, 0);
				$month = sqlsrv_get_field( $stmt, 1);
				$numof_CRQs = sqlsrv_get_field( $stmt, 3);
				$data_month = date("F", mktime(0, 0, 0, $month, 10))." ".$year;
				$data_Val[$dept][$data_month] = $numof_CRQs;
				$data_Date[$i] = $data_month;
				//print_r($data_Val[$dept]);
				//print_r($data_Desc);
				//print_r($data_Date);
				//echo $data_Val[$dept][$data_Date]."<BR>";
				sqlsrv_free_stmt( $stmt);
			}
			
			
		}
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataTable = google.visualization.arrayToDataTable([           
			/*	['Month', 'IT Operations', 'Network Engineering','Products & Services Delivery','Regional Operations','Service Management'],
				['2 2013',1,2,3,4,5,6],
				['1 2013',2,1,3,5,6,4],
				['12 2012',5,4,3,1,2,6],
			*/
			['Month',  
			<?php	for($i=0;$i<count($array_depts); $i++) {             
						echo "'".$array_depts[$i]."'";
						if ($i<count($array_depts)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($data_Date as &$month) {             
					echo "['".$month."',"; 
					$j=0;
					foreach ($array_depts as &$dept) {            
						echo $data_Val[$dept][$month]; 
						if ($j<count($array_depts)-1) echo ",";	
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
		var options = { title: 'Normal Scheduled Changes'  ,  chartArea:{left:40,top:30,width:"70%",height:"70%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Normal Scheduled Changes per Department', titleTextStyle: {color: 'red'}, gridlines:{count:0}}   };          
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));         
		chart.draw(dataTable, options);       
	} 
</script>   
<table >
	<tr><td width="600px" class="iframe_td"><div id="chart_div" style="width: 600px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>





