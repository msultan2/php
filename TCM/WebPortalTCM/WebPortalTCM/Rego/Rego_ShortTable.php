<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  

		if (isset($_GET['region'])) {
			
			/*if ($_GET['region'] === 'Cairo_East') {
				$RegionCondition = " SS.Region ='Cairo' AND SS.Area IN ('Obour','1st Gathering','5th Gathering and Kattamya','Shorouk and Badr','10th of Ramadan') ";
				$tableRegion = 'Cairo';
			}
			else if ($_GET['region'] === 'Cairo_West') {
				$RegionCondition = " SS.Region ='Cairo' AND NOT SS.Area IN ('Obour','1st Gathering','5th Gathering and Kattamya','Shorouk and Badr','10th of Ramadan') ";
				$tableRegion = 'Cairo';
			}
			else */
			if ($_GET['region'] === 'Canal_Red') {
				$RegionCondition = " SS.Region ='Canal' AND NOT SS.Area IN ('Sharm Elshikh','Nuweiba','Dahab','Taba','Arish','Sinai South_Rural','Sinai North_Rural') ";
				$tableRegion = 'Canal';
			}
			else if ($_GET['region'] === 'Canal_Sinai') {
				$RegionCondition = " SS.Region ='Canal' AND SS.Area IN ('Sharm Elshikh','Nuweiba','Dahab','Taba','Arish','Sinai South_Rural','Sinai North_Rural') ";
				$tableRegion = 'Sinai';
			}
			else {
				$tableRegion = $_GET['region'];
				$RegionCondition = " SS.Region like '$tableRegion%' ";
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
		//Down Scattered Sites WHERE SS.Region = 'Cairo'
		$sql = "SELECT SS.Site_Type,SS.Area,COUNT(DS.Site_ID) Down,COUNT(SS.Site_ID) AllSites
				  FROM  dbo.tbl_SS_LK_SubRegions_Sites SS
				  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END )
				  WHERE $RegionCondition
				  GROUP BY SS.Site_Type,SS.Area
				  ORDER BY 3 DESC;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		//echo "qqqq: ".$sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$area = $row['Area'];
			if ($area === "sahary alahram") $area = "Sahary AlAhram";
			if ($area === "1st gathering") $area = "1st Gathering";
			if ($area === "Kafr El Sheik_Rural") $area = "Kafr Shikh Rural";
			
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
		//echo "area: ".$area." type: ".$type."3G: ".$data_3G_Per_DownSites[$area]."2G: ".$data_2G_Per_DownSites[$area];
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
		
		$data_area = array_unique($data_area);
		$aggr_SS = count($data_area);
		
		
		echo "<table class=SStable align=center >";						
		echo "<td align=center colspan=5><B>".$tableRegion."</B></td>";
		echo "<tr><th width=100px>Area</th><th colspan=2 width=30px>2G</th><th colspan=2 width=30px>3G</th></tr>";
		
		$found = 0;
		//for($index=0; $index < $aggr_SS; $index++){
		foreach ($data_area as $area) {
			//if($date==$thisDate){            
					//$area = $data_area[$index];
					$strArea = str_replace(" ","__",$area);
					if (isset($data_2G_Per_DownSites[$area]) && isset($data_2G_Per_DownSites[$area])) 
					if ($data_2G_Per_DownSites[$area] <= 90 || $data_3G_Per_DownSites[$area] <= 90) {
						$found ++;

						echo "<tr><td><a class=area_link href='Report_Area.php?area=$strArea' target='_blank'>".substr($area,0,17)."</a></td>";
		
						if($data_2G_Per_DownSites[$area] <= 100 && $data_2G_Per_DownSites[$area] >= 99) $severity = "green";
						if($data_2G_Per_DownSites[$area] <= 98 && $data_2G_Per_DownSites[$area] >= 95 ) $severity = "yellow";
						if($data_2G_Per_DownSites[$area] <= 94 && $data_2G_Per_DownSites[$area] >= 90 ) $severity = "orange";
						if($data_2G_Per_DownSites[$area] <= 89 && $data_2G_Per_DownSites[$area] >= 75 ) $severity = "red";
						if($data_2G_Per_DownSites[$area] <= 74 ) $severity = "black";
						echo "<td class=SSS_".$severity.">".$data_2G_Per_DownSites[$area]."%</td>";
						echo "<td>".$data_2G_Val_DownSites[$area]."</td>";
						
						if($data_3G_Per_DownSites[$area] <= 100 && $data_3G_Per_DownSites[$area] >= 99) $severity = "green";
						if($data_3G_Per_DownSites[$area] <= 98 && $data_3G_Per_DownSites[$area] >= 95 ) $severity = "yellow";
						if($data_3G_Per_DownSites[$area] <= 94 && $data_3G_Per_DownSites[$area] >= 90 ) $severity = "orange";
						if($data_3G_Per_DownSites[$area] <= 89 && $data_3G_Per_DownSites[$area] >= 75 ) $severity = "red";
						if($data_3G_Per_DownSites[$area] <= 74 ) $severity = "black";
						echo "<td class=SSS_".$severity.">".$data_3G_Per_DownSites[$area]."%</td>";
						echo "<td>".$data_3G_Val_DownSites[$area]."</td>";
						echo "</tr>";
					}
					
					
			//	}
			
		}
		if($found==0){
			echo "<tr><td colspan=5 class=SSS_green align=center>Clear (> 90%)</td><tr>";
		}
		echo "</table><br>";
?>					