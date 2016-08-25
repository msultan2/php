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
		$sql = "SELECT TOP 10 Product_Categorization_Tier_1 tier,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name, count(*) CRQnum
					FROM  dbo.vw_Change_Approval_Details cap
					WHERE cap.Scheduled_Start_Date <= getdate() 
					AND cap.CRQ_Type = 'Normal'
					AND Status <> 'Request For Authorization'
					GROUP BY Product_Categorization_Tier_1,cap.Support_Company,cap.Support_Organization,cap.Support_Group_Name
					ORDER BY CRQnum DESC;	";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['tier']);
			array_push($data_dept,$row['Support_Company']);
			array_push($data_team,$row['Support_Group_Name']);
			array_push($data_Val,$row['CRQnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	// Load the Visualization API and the controls package.       
	google.load("visualization", "1",  {'packages':['controls']});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
			
		var dataChart = google.visualization.arrayToDataTable([   
			['Change Tier', 'Number of Changes'],
			<?php 
				for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] ); 

		
		//drawPieChart
		var chart = new google.visualization.Dashboard(document.getElementById('dashboard_div'));         
		var donutRangeSlider = new google.visualization.ControlWrapper({    'controlType': 'NumberRangeFilter',           
																			'containerId': 'filter_div',           
																			'options': { 'filterColumnLabel': 'Number of Changes', 
																			'width': '600',   'height': '150'           }         });          
		// Create a pie, bar or line chart, passing some options         
		var myChart = new google.visualization.ChartWrapper({           'chartType': 'PieChart',           'containerId': 'chart_div',           'options': {             'width': 600,             'height': 350,             'pieSliceText': 'percent',             'legend': 'right'           }         });          
		// Establish dependencies, declaring that 'filter' drives 'pieChart',         
		// so that the pie chart will only display entries that are let through         
		// given the chosen slider range.         
		chart.bind(donutRangeSlider, myChart); 
		chart.draw(dataChart);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td">
		<!--Div that will hold the dashboard-->     
		<div id="dashboard_div">       
			<!--Divs that will hold each control and chart-->       
			<div id="filter_div"></div>       
			<div id="chart_div"></div>     
		</div>
		</td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>