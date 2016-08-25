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
		$sql = "SELECT CASE WHEN TT.Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
									THEN TT.Assigned_Group
								ELSE 'Others'
						END Assigned_Group,
						CASE WHEN TT.Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
									THEN 1
								ELSE 2
						END Sort_Order,COUNT(vio.Incident_ID) Violated_TT,COUNT(*) Total_TT
				  FROM dbo.[vw_SS_Remedy_TT_SLA_Assigned] TT
				  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				  ON TT.Incident_ID = vio.Incident_ID
				  WHERE TT.Assigned_Group IS NOT NULL
				  AND TT.OUTAGE <> 'Yes'
				  group by CASE WHEN TT.Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
									THEN TT.Assigned_Group
								ELSE 'Others'
						END,
						CASE WHEN TT.Assigned_Group IN ('Alex & Delta Access Service FO','Cairo Access Service FO','HU Access Service FO','BEP FO','PTN-RTN FO','Transport FO Datacom','Transport FO Tx')
									THEN 1
								ELSE 2
						END
				  HAVING COUNT(vio.Incident_ID) > 0
				  order by 2,3 DESC;";
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

<html>
	<head>
		
		<script src="Chart.js-master/Chart.js"></script>
	</head>
	<body>
	<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels :[ 
		<?php           
				for($i=0;$i<count($data_team); $i++) {
						echo '<a href=\"Queues_Links.php?team=".$data_team[$i]."\" target=\'_blank\'>".$data_team[$i]."</a>'; 
						if ($i<count($data_team)-1) echo ",";	//add ',' to all except last element
					} 
			?>
		
		],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [ <?php for($i=0;$i<count($data_Val); $i++) { echo "$data_Val[$i]"; if ($i<count($data_Val)-1) echo ",";} ?>]
			}
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}

	</script>
	<div style="width: 30%">
			<canvas id="canvas" height="450" width="600"></canvas>
	</div>
	</body>
</html>
