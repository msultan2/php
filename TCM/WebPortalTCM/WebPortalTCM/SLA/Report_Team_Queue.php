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
		$sql = "SELECT Assigned_Group,COUNT(vio.Incident_ID) Violated_TT
				  FROM dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				  WHERE Assigned_Group IS NOT NULL
				  AND Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO')
				  group by Assigned_Group
				  order by 2 DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Total = array();
		$data_Val = array();
		$data_dept = array();
		$data_team = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_team,$row['Assigned_Group']);
			array_push($data_Val,$row['Violated_TT']);
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(drawAll);      

	function drawAll() {         
		var dataChart = google.visualization.arrayToDataTable([   
			['Team', 'TTs'],
			<?php 
				for($i=0;$i<count($data_team); $i++) {             
						echo "['".$data_team[$i]."',". $data_Val[$i] ."]"; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataChart, {showRowNumber: true});       
		
		//drawPieChart
		var options = { title: 'Team Queues'  ,  chartArea:{left:200,top:40,bottom:20,width:"75%",height:"80%"}, colors:['darkgreen'], //vAxis: {maxValue:3, minValue:1},
						hAxis: {title: 'SOC Access', titleTextStyle: {color: 'red'}, gridlines:{count:7}}  };          
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		chart.draw(dataChart, options);       
	} 
</script>   
<table >
	<tr><td  class="iframe_td"><div id="chart_div" style="width: 500px; height: 300px;"></div>  </td></tr>
	<tr><td ><div id="table_div" ></div></td></tr>
</table>
