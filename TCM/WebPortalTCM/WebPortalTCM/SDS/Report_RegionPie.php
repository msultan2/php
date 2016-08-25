<?php
	if (isset($_GET['type'])) 
		$tableType = $_GET['type'];
		
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
		$sql = "SELECT CASE SS.Region 	WHEN  'Alexandria' THEN 'Alex'
										WHEN 'Upper Egypt' THEN 'Upper'
										ELSE SS.Region 
										END Region, COUNT(DS.Site_ID) downSites
				FROM [dbo].tbl_SS_LK_SubRegions_Sites SS
				  LEFT OUTER JOIN dbo.[tbl_SS_DownSites] DS
								  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
															ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
															END ) ";
				  
		if (isset($_GET['type'])) $sql .= "	WHERE SS.Site_Type = '$tableType' ";
		
		$sql .=   "GROUP BY CASE SS.Region 	WHEN  'Alexandria' THEN 'Alex'
										WHEN 'Upper Egypt' THEN 'Upper'
										ELSE SS.Region 
										END				  
					ORDER BY 1 ASC;";
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			//preg_match('/(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp); //(?P<x>\d+)-
			//$Impact = $Impact_Exp['impact_level'];
			array_push($data_Desc,$row['Region']);
			array_push($data_Val,$row['downSites']);
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1", {packages:["corechart"]});
	google.load("visualization", "1",{packages:['table']}); 
	google.setOnLoadCallback(draw_ChangeTypes);  
	
	function draw_ChangeTypes() {         
		var data = google.visualization.arrayToDataTable([           
			['Region', 'Scattered Down Sites'],           
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
		var options = {           title: '<?php echo $tableType; ?> SDS per Region'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 300px; height: 200px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 270px; height: 200px;" ></div>  </td>
	</tr></table>
