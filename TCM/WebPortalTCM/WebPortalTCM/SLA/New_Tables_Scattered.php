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
		$sql = "SELECT 
							CASE WHEN TT.Grade = 'P1' THEN 'Grade1'
							WHEN TT.Grade = 'P2' THEN 'Grade2'
							WHEN TT.Grade = 'P3' THEN 'Grade3'
							WHEN TT.Grade = 'P4' THEN 'Grade4'
							END Severity, 
						CASE WHEN TT.Grade = 'P1' THEN 1
							WHEN TT.Grade = 'P2' THEN 2
							WHEN TT.Grade = 'P3' THEN 3
							WHEN TT.Grade = 'P4' THEN 4
							END Severity_Order, 
							COUNT(vio.Incident_ID) Violated_TTs,
							COUNT(*) Total_TT
						  FROM dbo.vw_SS_Remedy_TT_SLA_All TT
						  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
						  ON TT.Incident_ID = vio.Incident_ID
						  WHERE TT.Outage = 'No'
						  AND TT.Incident_ID IS NOT NULL
						  GROUP BY CASE WHEN TT.Grade = 'P1' THEN 'Grade1'
							WHEN TT.Grade = 'P2' THEN 'Grade2'
							WHEN TT.Grade = 'P3' THEN 'Grade3'
							WHEN TT.Grade = 'P4' THEN 'Grade4'
							END, 
						CASE WHEN TT.Grade = 'P1' THEN 1
							WHEN TT.Grade = 'P2' THEN 2
							WHEN TT.Grade = 'P3' THEN 3
							WHEN TT.Grade = 'P4' THEN 4
							END
						ORDER BY 2;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Total = array();
		$data_Violated = array();
		$data_Severity = array();		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Severity,$row['Severity']);
			array_push($data_Violated,$row['Violated_TTs']);
			array_push($data_Total,$row['Total_TT']);
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
			['Severity','Violated_TT','Total_TT'], 
			<?php 
				for($i=0;$i<count($data_Severity); $i++) {             
						
						echo "['<a href=\"New_Tables_Scattered_Links.php?color=".$data_Severity[$i]."\" target = \'_blank\'>".$data_Severity[$i]."</a>','".$data_Violated[$i]."','".$data_Total[$i]."']"; 
						if ($i<count($data_Severity)-1) echo ",";	//add ',' to all except last element
					} 
			?>
			] );
				dataChart.setColumnProperty(0, {allowHtml: true});
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataChart, {showRowNumber: true});
		table.draw(dataChart, {allowHtml: true});
			
		
		var view = new google.visualization.DataView(dataChart);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);      
	} 
	
	
	
	
	
</script>   
<table  >
	<tr>
	<td ><div id="table_div" style="width: 300px;"></div></td>
	</tr>
</table>
