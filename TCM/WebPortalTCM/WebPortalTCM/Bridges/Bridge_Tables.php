<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php	  

		if (isset($_GET['Bridge'])) {
			
			if ($_GET['Bridge'] === 'Mehwar') {
				$BridgeCondition = "Description LIKE '%Mehwar%' AND Description NOT LIKE '%Ring%Road%'";
				$tableBridge = 'Mehwar';
			}
			else if ($_GET['Bridge'] === 'Ring_Road') {
				$BridgeCondition = " Description LIKE '%Ring%Road%'";
				$tableBridge = 'Ring Road';
			}
			else if ($_GET['Bridge'] === '6_Of_October') {
				$BridgeCondition = "Description LIKE '%6%Oct%' ";
				$tableBridge = '6 Of October';
			}
		}	
		$data_area = array();
		$data_2G_Val_DownSites = array();
		$data_2G_Per_DownSites = array();
		$data_3G_Val_DownSites = array();
		$data_3G_Per_DownSites = array();
		
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT COUNT (DS.Site_ID) Down,COUNT (BR.Site_ID) AllSites,
			Description Area,BR.Site_Type
			FROM  [SM_Change_Researching_DB].[dbo].[tbl.Bridgs] BR
			LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
			ON BR.Site_ID IN (SELECT DS.Site_ID
			FROM dbo.tbl_SS_DownSites)
			WHERE $BridgeCondition		
			GROUP BY BR.Description,BR.Site_Type;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$area = $row['Area'];
			array_push($data_area,$area);
			$type = $row['Site_Type'];
			
			if($type === '2G') {
				$data_2G_Val_DownSites[$area] = $row['Down'];
				$data_2G_Per_DownSites[$area] = 100 - round(( $row['Down'] / $row['AllSites'] )*100 , 0);
			}
			else if($type === '3G') {
				$data_3G_Val_DownSites[$area] = $row['Down'];
				$data_3G_Per_DownSites[$area] = 100 - round(( $row['Down'] / $row['AllSites'] )*100 , 0);
			}
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
		
		$data_area = array_unique($data_area);
		$aggr_SS = count($data_area);
		 		
		echo "<table class=SStable align=center>";	
		
		echo "<td align=center colspan=5><B>".$tableBridge."</B></td>";
		
		echo "<tr><th>Area</th><th>2G</th><th>3G</th></tr>";

		foreach ($data_area as $area) {

					$strArea = str_replace("-","%",$area);
					echo "<tr><td><a class=area_link href='Report_Area.php?area=$strArea' target='_blank'>".substr($area,0,40)."</a></td>";					
					echo "<td>".$data_2G_Val_DownSites[$area]."</td>";
					echo "<td>".$data_3G_Val_DownSites[$area]."</td>";
					echo "</tr>";
			
		}
		echo "</table>";

?>					
