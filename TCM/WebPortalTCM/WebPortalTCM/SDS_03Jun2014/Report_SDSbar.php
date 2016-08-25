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
		$sql = "SELECT downRegion,[2G], [3G] 
				  FROM (
				  SELECT SS.Site_Type downSite,CASE  SS.Region WHEN 'Alexandria' THEN 'Alex' WHEN 'Upper Egypt' THEN 'Upper' ELSE SS.Region END downRegion,
				   ROUND(100 - (COUNT(DS.Site_ID)*1.0  / COUNT(SS.Site_ID)*1 )*100 ,0) SDS
							FROM dbo.tbl_SS_LK_SubRegions_Sites SS
							  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
							  ON  SS.Site_ID = DS.Site_ID AND SS.Area = DS.Area
							GROUP BY SS.Site_Type,CASE  SS.Region WHEN 'Alexandria' THEN 'Alex' WHEN 'Upper Egypt' THEN 'Upper' ELSE SS.Region END
					) queryA
					PIVOT 
						( max(SDS)
							for downSite in ([2G],[3G])
						) queryP
						
					ORDER BY 1 ASC;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val_2G = array();
		$data_Val_3G = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['downRegion']);
			array_push($data_Val_2G,$row['2G']);
			array_push($data_Val_3G,$row['3G']);
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
			['Region', '2G','3G'],           //,  { role: 'annotation' }
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val_2G[$i].",".$data_Val_3G[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(data, {showRowNumber: true});       
		
		//drawPieChart 
		// , hAxis:{minValue:0, maxValue:100}
		var options = {           title: 'Availability % per Region'  , is3D: true  , chartArea:{left:60,top:20,width:"40%",height:"80%"} };          
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));         
		chart.draw(data, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 500px; height: 300px;"></div>  </td>
	</tr>
	<tr>
		<td ><div id="table_div" style="width: 270px; height: 200px;" ></div>  </td>
	</tr></table>
