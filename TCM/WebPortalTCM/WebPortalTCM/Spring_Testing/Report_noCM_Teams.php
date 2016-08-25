<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php

		$weekback = date('m/d/Y', time() + (60 * 60 * 24 * -7));
		$yesterday = date('m/d/Y', time() + (60 * 60 * 24 * -1));
		//echo $weekback." ".$yesterday;

		if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $weekback;
		if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $yesterday;
	
	
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
		$sql = "SELECT  CASE WHEN ap.Support_Company = 'Regional Operations' THEN Support_Company ELSE support_organization END team,count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details ap
					WHERE Status NOT IN ('Request For Authorization','Cancelled')
					AND dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
					AND CRQ_Type = 'Standard'
					AND [First Approval Date] IS NULL
					GROUP BY CASE WHEN ap.Support_Company = 'Regional Operations' THEN Support_Company ELSE support_organization END
					ORDER BY CRQnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Val = array();
		$data_team = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_team,$row['team']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	// Load the Visualization API and the controls package.       
	google.load("visualization", "1",  {'packages':['corechart']});
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
			
		var dataChart = google.visualization.arrayToDataTable([   
			['Change Tier', 'Number of Changes'],
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_team[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] ); 

		
		//drawPieChart
		var options = { title: 'Changes OUT of process/ Team'  ,  chartArea:{left:10,top:30,width:"75%",height:"70%"} , pieHole: 0.3 };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td><div id="chart_div" style="width: 300px; height: 400px;"></div>  </td></tr>
</table>