<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	error_reporting(-1);
	
		//$ScatteredSitesFile = file('input/ALLSS.txt');
		//$fileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/ALLSS.TXT';
		
		$fileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.TXT';
		$ScatteredSitesFile = file($fileName);
		//$newFileName = 'E:/TCM/WebPortalTCM/WebPortalTCM/Rego/input/newInput_'.date('Ymd_Hi').'.txt';
		$newFileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/SDS/ALLSS_'.date('Ymd_Hi').'.txt';
		
		//$ScatteredSitesFile = file('\\vf-eg.internal.vodafone.com\technology\TM\Service Management\GOOGLE\AAAAA\ALLSS.TXT');
		//$ScatteredSitesFile = file('//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.TXT');
		
		if (is_file($ScatteredSitesFile)) echo "file exists";
		else echo "file doesn't exist";
		$ScatteredSitesDown = array();
		$impactedAreas = array();
		
		$num_SS = count($ScatteredSitesFile);
		echo "Number is: ".$num_SS;
		for($index=0; $index < $num_SS; $index++){
			//if(strpos($ScatteredSitesFile[$index],$thisDate)){
			list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[$index],10);
			$ScatteredSitesDown[$r_area] = $ScatteredSitesDown[$r_area] + 1;
			
			$dataString = str_replace('"',"",$site_ID).",".$x.",".$y.",".str_replace('"',"",$r_BSC_RNC).",".str_replace('"',"",$r_site_type).",".str_replace('"',"",$r_down_date).",".str_replace('"',"",$r_area).",".str_replace('"',"",$r_region).",".str_replace('"',"",$r_lastModified_date).",".str_replace('"',"",$z);
			file_put_contents($newFileName, $dataString, FILE_APPEND );
			//list($area,$region,$num_downSites)=split(',',"$r_area,$r_region,$ScatteredSitesDown[$r_area]");
			
			array_push($impactedAreas,$r_area);
		}
		fclose($newFileName);
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
		//$newfile = fopen("Sara.txt", "w+a");  
		//fwrite($newfile, "Hello".'\n'."WOrld");  
		////fclose($newfile); 



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
		
		if ($aggr_SS > 0) {
			$sql="TRUNCATE TABLE dbo.tbl_ss_downsites;";
			
			$stmt = sqlsrv_query( $conn, $sql);
			if( $stmt === false ) {
				die( print_r( sqlsrv_errors(), true));
			}
			
			sqlsrv_free_stmt( $stmt);
			
			$sql="BULK
					INSERT dbo.tbl_SS_DownSites
					FROM '$newFileName'
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
			
			sqlsrv_free_stmt( $stmt);
		}
		sqlsrv_close( $conn ); 
		
		/*DROP Table tbl_SS_DownSites_History
		SELECT * INTO [SM_Change_Researching_DB].[dbo].[tbl_SS_DownSites_History]
			FROM [SM_Change_Researching_DB].[dbo].[tbl_SS_DownSites]
		*/
		
?>					