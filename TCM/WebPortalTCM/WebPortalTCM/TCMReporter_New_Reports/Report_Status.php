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
		$array_depts = array("IT Operations","Network Engineering","Products & Services Delivery","Regional Operations","Service Management");
		$array_status = array('Request For Authorization', 'Scheduled','Rejected','Cancelled','Completed','Closed');
		
		$j=0;
		$data = array(); 
		$array_dept_total = array();
		foreach ($array_depts as &$dept) {
			$data[$dept] = array();
			foreach ($array_status as &$status) {
				$sql = "SELECT  count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Support_Company = '".$dept."'
					AND cap.Status = '".$status."'
					AND cap.CRQ_Type = 'Normal'
					--AND cap.Scheduled_Start_Date >= '10/1/2012'
					AND cap.Scheduled_Start_Date <= getdate() ;";
				//echo $sql;
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				if (sqlsrv_fetch($stmt)=== false){
					die( print_r( sqlsrv_errors(), true));
				}	 
				$numof_CRQs = sqlsrv_get_field( $stmt, 0);
				//echo $numof_CRQs;
				$data[$dept][$status]= $numof_CRQs;
				$array_dept_total[$dept] += $data[$dept][$status];
				sqlsrv_free_stmt( $stmt);
				$j = $j + 1;
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
			/*	['Department', 'Request For Authorization', 'Scheduled','Rejected','Cancelled','Completed','Closed'],
				['IT Operations',1,2,3,4,5,6],
				['Network Engineering',2,1,3,5,6,4],
				['Products & Services Delivery',5,4,3,1,2,6],
				['Regional Operations',6,4,2,5,1,3],
				['Service Management',3,5,6,1,2,4]
			*/
			['Department',  
			<?php	for($i=0;$i<count($array_status); $i++) {             
						echo "'".$array_status[$i]."'";
						if ($i<count($array_status)-1) echo ",";	//add ',' to all except last element
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($array_depts as &$dept) {             
					echo "['".$array_depts[$i]."',"; 
					$j=0;
					foreach ($array_status as &$status) {            
						echo $data[$dept][$status]; 
						if ($j<count($array_status)-1) echo ",";	
						$j=$j+1;
					}
					echo "]";
					if ($i<count($array_depts)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 
		var dataTable = google.visualization.arrayToDataTable([           
			/*	['Department', 'Request For Authorization', 'Scheduled','Rejected','Cancelled','Completed','Closed'],
				['IT Operations',1,2,3,4,5,6],
				['Network Engineering',2,1,3,5,6,4],
				['Products & Services Delivery',5,4,3,1,2,6],
				['Regional Operations',6,4,2,5,1,3],
				['Service Management',3,5,6,1,2,4]
			*/
			['Department',  
			<?php	for($i=0;$i<count($array_status); $i++) {             
						echo "'".$array_status[$i]."'";
						if ($i<count($array_status)-1) echo ",";	//add ',' to all except last element
						else echo ",'Total'";
					}
			?>
			],           
			<?php 
				$i=0;
				foreach ($array_depts as &$dept) {             
					echo "['".$array_depts[$i]."',"; 
					$j=0;
					foreach ($array_status as &$status) {            
						echo $data[$dept][$status]; 
						if ($j<count($array_status)-1) echo ",";	
						else echo ",".$array_dept_total[$dept];
						$j=$j+1;
					}
					echo "]";
					if ($i<count($array_depts)-1) echo ",";	//add ',' to all except last element
					$i=$i+1;
				}
			?>
			] ); 	
					
					
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Changes Status'  ,  chartArea:{left:40,top:30,width:"70%",height:"70%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Normal Changes Per Status per Department', titleTextStyle: {color: 'red'}, gridlines:{count:0}}   };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td" width="700px"><div id="chart_div" style="width: 650px; height: 400px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>