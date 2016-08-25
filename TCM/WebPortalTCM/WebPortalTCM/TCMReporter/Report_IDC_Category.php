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
		$sql_old = "SELECT CASE inc.Category
							   WHEN 'IT Incident' THEN 'IT Incident'
							   ELSE 'NW Incident'
							  END Category, count(*) INCnum
							FROM dbo.tbl_Incident_TechIMReport inc
							WHERE inc.[Start Date] > '11/1/2012'
							AND Dueto_Change = 1
							GROUP BY CASE inc.Category
							   WHEN 'IT Incident' THEN 'IT Incident'
							   ELSE 'NW Incident'
							  END
							ORDER BY INCnum DESC; ";
		
		$sql = "SELECT CASE inc.Category
						   WHEN 'IT Incident' THEN 'IT Incident'
						   WHEN 'Fixed Network' THEN 'Fixed Network'
						   WHEN 'Coverage' THEN 'Coverage'
						   ELSE 'Services'
						END Category, count(*) INCnum
				FROM dbo.tbl_Incident_IDC inc
						WHERE inc.[Start Date] > '11/1/2012'
						AND Dueto_Change = 1
						GROUP BY CASE inc.Category
						   WHEN 'IT Incident' THEN 'IT Incident'
						   WHEN 'Fixed Network' THEN 'Fixed Network'
						   WHEN 'Coverage' THEN 'Coverage'
						   ELSE 'Services'
						  END
						ORDER BY INCnum DESC; ";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Category']);
			array_push($data_Val,$row['INCnum']);
		}
		
		sqlsrv_free_stmt( $stmt);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeTypes);  
	
	function draw_ChangeTypes() {         
		var data = google.visualization.arrayToDataTable([           
			['Type of Incident', 'Number of Incidents due to Changes'],           
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
		var options = {           title: 'IDCs Categories'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 320px; height: 200px;" ></div>  </td>
	</tr></table>
<?php sqlsrv_close( $conn ); ?>