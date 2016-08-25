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
		$sql0 = "SELECT downRegion,[2G], [3G] 
				  FROM (
				  SELECT SS.Site_Type downSite,CASE  SS.Region WHEN 'Alexandria' THEN 'Alex' WHEN 'Upper Egypt' THEN 'Upper' ELSE SS.Region END downRegion,
				   COUNT(DS.Site_ID) SDS
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
		
		// Get down sites
		$sql = "SELECT downRegion,[2G], [3G] 
				  FROM (
				  SELECT SS.Site_Type downSite,CASE  SS.Region WHEN 'Alexandria' THEN 'Alex' WHEN 'Upper Egypt' THEN 'Upper' ELSE SS.Region END downRegion,
				   COUNT(DS.Site_ID) SDS
							FROM dbo.tbl_ss_downsites DS , dbo.tbl_SS_LK_SubRegions_Sites SS
							  WHERE  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
															ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
															END )
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
		$sum = 0;
		$sum2G = 0;
		$sum3G = 0;
		$data_Desc = array();
		$data_Val_2G = array();
		$data_Val_3G = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['downRegion']);
			array_push($data_Val_2G,$row['2G']);
			array_push($data_Val_3G,$row['3G']);
			$sum = $sum + $row['2G'] + $row['3G'];
			$sum2G = $sum2G + $row['2G'];
			$sum3G = $sum3G + $row['3G'];
		}
		sqlsrv_free_stmt( $stmt);
		
		// Get All sites
		$sql = "SELECT downRegion,[2G], [3G] 
				  FROM (
				  SELECT SS.Site_Type downSite,CASE  SS.Region WHEN 'Alexandria' THEN 'Alex' WHEN 'Upper Egypt' THEN 'Upper' ELSE SS.Region END downRegion,
				   COUNT(SS.Site_ID) SDS
							FROM dbo.tbl_SS_LK_SubRegions_Sites SS
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
		$sumAll = 0;
		$sumAll2G = 0;
		$sumAll3G = 0;
		$data_Desc = array();
		$data_All_2G = array();
		$data_All_3G = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['downRegion']);
			array_push($data_All_2G,$row['2G']);
			array_push($data_All_3G,$row['3G']);
			$sumAll = $sumAll + $row['2G'] + $row['3G'];
			$sumAll2G = $sumAll2G + $row['2G'];
			$sumAll3G = $sumAll3G + $row['3G'];
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
		var dataTable = google.visualization.arrayToDataTable([           
			['Region', 'Down 2G',' All 2G','Down 3G','All 3G','Down Total'],           //,  { role: 'annotation' }
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val_2G[$i].",".$data_All_2G[$i].",".$data_Val_3G[$i].",".$data_All_3G[$i].",".($data_Val_2G[$i]+$data_Val_3G[$i])."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
				echo ",['Grand Total',".$sum2G.",".$sumAll2G.",".$sum3G.",".$sumAll3G.",".($sum2G+$sumAll2G+$sum3G+$sumAll3G)."]";
			?>
			] ); 
		//drawTable
		var table = new google.visualization.Table(document.getElementById('table_div'));         
		table.draw(dataTable, {showRowNumber: false});       
		
		var view = new google.visualization.DataView(data);
		view.setColumns([0, 
						1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2,
					   { calc: "stringify",
                         sourceColumn: 2,
                         type: "string",
                         role: "annotation" }]);
		//drawPieChart 
		// , hAxis:{minValue:0, maxValue:100}
		var options = {           title: '<?php echo $sum;?> Down Sites per Region'  , is3D: true  , chartArea:{left:60,top:20,width:"80%",height:"75%"} };          
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));         
		chart.draw(view, options);       
	} 
</script>   
	<table ><tr>
		<td><div id="chart_div" style="width: 800px; height: 230px;"></div>  </td>
		<td ><div id="table_div" style="width: 400px; height: 230px;" ></div>  </td>
	</tr></table>
