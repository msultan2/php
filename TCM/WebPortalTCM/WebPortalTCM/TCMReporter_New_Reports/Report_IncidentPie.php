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
		$sql_old = "SELECT inc.Owner_Team, count(*) INCnum
				FROM dbo.tbl_Incident_TechIMReport inc
				WHERE inc.[Start Date] > '11/1/2012'
				AND Dueto_Change = 1
				GROUP BY inc.Owner_Team
				ORDER BY INCnum DESC;";
		$sql = "SELECT CASE WHEN inc.Owner_Team = 'Other'
							  AND inc.Category = 'Coverage'
							THEN 'NFM'
							WHEN inc.Owner_Team = 'IT-Security'
							THEN 'IT Security'
							ELSE team_map.Support_Group
						END Owner_Team, count(*) INCnum
								FROM dbo.tbl_Incident_TechIMReport inc LEFT OUTER JOIN dbo.tbl_Incident_LK_Team_Mapping team_map
						ON inc.Owner_Team = team_map.INC_OwnerTeam
								WHERE inc.[Start Date] > '11/1/2012'
								AND Dueto_Change = 1
								GROUP BY CASE WHEN inc.Owner_Team = 'Other'
									  AND inc.Category = 'Coverage'
									THEN 'NFM'
									WHEN inc.Owner_Team = 'IT-Security'
									THEN 'IT Security'
									ELSE team_map.Support_Group
								END
								ORDER BY INCnum DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Owner_Team']);
			array_push($data_Val,$row['INCnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeFor);
	
	function draw_ChangeFor(){
		var data = google.visualization.arrayToDataTable([           
			['Team', 'Incidents due to Changes'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});       
		
		//drawPieChart
		var options = {           title: 'Incidents due to Changes\n (since Nov 2012)'  , is3D: true  , chartArea:{left:20,top:20,width:"60%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	}
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 500px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 330px; height: 150px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>