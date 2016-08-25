<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
		//$ScatteredSitesFile = file('input/ALLSS.txt');
		$ScatteredSitesFile = file('G:/TM/Service Management/GOOGLE/AAAAA/ALLSS.TXT');
		$ScatteredSitesDown = array();
		$impactedAreas = array();
		
		$num_SS = count($ScatteredSitesFile);
		for($index=0; $index < $num_SS; $index++){
			//if(strpos($ScatteredSitesFile[$index],$thisDate)){
			list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[$index],10);
			$ScatteredSitesDown[$r_area] = $ScatteredSitesDown[$r_area] + 1;
			
			//list($area,$region,$num_downSites)=split(',',"$r_area,$r_region,$ScatteredSitesDown[$r_area]");
			
			array_push($impactedAreas,$r_area);
			//if($date==$thisDate){
					echo "<table class=SStable align=center >";						
					echo "<tr><th width=20%>Area</th><td>".$area. "</td></tr>";
					echo "<tr><th width=80%>Region</th><td>".$region."</td></tr>";
					echo "<tr><th>X</th><td >".$ScatteredSitesDown[$area]."</td></tr>";
					echo "<tr><th>Y</th><td >".$y."</td></tr>";
					//echo "<tr><th>Severity</th><td class=".$pa_severity." >".$pa_severity."</td></tr>";
					echo "</table><br>";
			
			//	}
		}
		/*$aggr_SS = count($impactedAreas);
		for($index=0; $index < $aggr_SS; $index++){    
					$area = $impactedAreas[$index];
					echo "INSERT INTO dbo.tbl_SS_DownSites VALUES ('".$area. "',$ScatteredSitesDown[$area]);<BR>";
		}
		*/
		$aggr_SS = count($impactedAreas);
		for($index=0; $index < $aggr_SS; $index++){
			//if($date==$thisDate){            
						$area = $impactedAreas[$index];
					echo "<table class=SStable align=center >";						
					echo "<tr><th width=20%>Area</th><td>".$area. "</td></tr>";
					echo "<tr><th width=80%>Region</th><td>".$aggr_SS."</td></tr>";
					echo "<tr><th>Down Sites</th><td >".$ScatteredSitesDown[$area]."</td></tr>";
					//echo "<tr><th>Severity</th><td class=".$pa_severity." >".$pa_severity."</td></tr>";
					echo "</table><br>";
			
			//	}
		}
		
		/* Parse configuration file */
		//$ini_array = parse_ini_file("config.ini");
	
		/* Specify the server and connection string attributes. */

		//$serverName = $ini_array['SERVER_NAME']; 
		//$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
	/*	$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql="BULK
                INSERT dbo.tbl_SS_LK_SubRegions_Sites
                FROM 'E:\\TCM\\WebPortalTCM\\WebPortalTCM\\Rego\\input\\SS_LK.csv'
                WITH
                (
                FIELDTERMINATOR = ',',
                ROWTERMINATOR = '\n',
                FIRSTROW=2
                )";
		$stmt = sqlsrv_query( $conn, $sql);
		if( $stmt === false ) {
			die( print_r( sqlsrv_errors(), true));
		}
		*/
?>					