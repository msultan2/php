<?php
/* Specify the server and connection string attributes. */
		$serverName = "egzhr-wie2e01"; //10.230.95.87
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$array_depts = array("IT Operations","Network Engineering","Products & Services Delivery","Regional Operations","Service Management");
		$array_status = array('Request For Authorization', 'Scheduled','Rejected','Cancelled','Completed','Closed');
		
		$j=0;
		$data = array(); 
		foreach ($array_depts as &$dept) {
			$data[$dept] = array();
			foreach ($array_status as &$status) {
				$sql = "SELECT  count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Support_Company = '".$dept."'
					AND cap.Status = '".$status."'
					AND cap.CRQ_Type = 'Normal'
					AND cap.Scheduled_Start_Date <= getdate() AND cap.Scheduled_Start_Date >= '10/1/2012';";
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
				
				sqlsrv_free_stmt( $stmt);
				$j = $j + 1;
			}
		}
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
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
		
		//drawPieChart
		var options = { title: 'Changes Status'  ,  chartArea:{left:40,top:30,width:"70%",height:"70%"}, vAxis: {gridlines:{count:8}}, //maxValue:3, minValue:1},
						hAxis: {title: 'Number of Normal Changes Per Status Per Dept in the last 3 months', titleTextStyle: {color: 'red'}, gridlines:{count:0}}   };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(dataTable, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 900px; height: 400px;"></div>  </td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>