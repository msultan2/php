<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	error_reporting(-1);
		
	$fileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/GOOGLE/AAAAA/ALLSS.TXT';
	$ScatteredSitesFile = file($fileName);
	if(!file_exists($fileName))
		echo "Cannot read OSS file!!";
	//echo "AllSS: ".file_get_contents('//vf-eg.internal.vodafone.com/technology/TM/Service Management/ALLSS.TXT');
	//@readfile('//vf-eg.internal.vodafone.com/technology/TM/Service Management/ALLSS.TXT');
	$newFileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/SDS/ALLSS_'.date('Ymd_Hi').'.txt';
	
	$ScatteredSitesDown = array();
	$impactedAreas = array();
	
	$num_SS = count($ScatteredSitesFile) -1;
	//echo "<U>Number of SDS: </U><B>".$num_SS."</B>";
	
	$i = 0;
	$DB_updated = false;
	while ($i < 10){
		$oldFileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/SDS/ALLSS_'.date('Ymd_Hi',time() - $i * 60).'.txt';
		if(file_exists($oldFileName)) {
			$DB_updated = true; 
			$ScatteredSitesOldFile = file($oldFileName);
			$num_SS = count($ScatteredSitesOldFile) - 1;
			echo "<BR><U>Number of SDS: </U><B> ".$num_SS."</B>";
			list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesOldFile[0],10);
			echo "<BR>OSS File Already loaded on ".date('d-m-Y H:i',time() - $i * 60).".. last update: ".$r_lastModified_date;
			break;
		}
		$i++;
	}
	
	if (!file_exists($newFileName) && !$DB_updated) {
	
		for($index=0; $index < $num_SS; $index++){
			//if(strpos($ScatteredSitesFile[$index],$thisDate)){
			list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[$index],10);
			$ScatteredSitesDown[$r_area] = $ScatteredSitesDown[$r_area] + 1;
			
			$dataString = str_replace('"',"",$site_ID).",".$x.",".$y.",".str_replace('"',"",$r_BSC_RNC).",".str_replace('"',"",$r_site_type).",".str_replace('"',"",$r_down_date).",".str_replace('"',"",$r_area).",".str_replace('"',"",$r_region).",".str_replace('"',"",$r_lastModified_date).",".str_replace('"',"",$z);
			//echo "line $index: ".$dataString;
			file_put_contents($newFileName, $dataString, FILE_APPEND );
			//list($area,$region,$num_downSites)=split(',',"$r_area,$r_region,$ScatteredSitesDown[$r_area]");
			
			array_push($impactedAreas,$r_area);
		}
		echo "<BR><U>Last Number of SDS: </U><B> ".$num_SS."</B>";
		list($site_ID,$x,$y,$r_BSC_RNC,$r_site_type,$r_down_date,$r_area,$r_region,$r_lastModified_date,$z)=split(',',$ScatteredSitesFile[0],10);
		echo "<BR>Loading.. Last Modified: ".str_replace('"',"",$r_lastModified_date);
		fclose($newFileName);
		$aggr_SS = count($impactedAreas);
		

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
			
			$sql = "SELECT COUNT(DS.Site_ID) Down
				  FROM  dbo.tbl_SS_LK_SubRegions_Sites SS
				  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END );";
				  
			$stmt = sqlsrv_query( $conn, $sql );
			$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
			echo "<BR>Number of SDS: ".$row['Down'];
			sqlsrv_free_stmt( $stmt);
		}
		sqlsrv_close( $conn ); 
		
		/*DROP Table tbl_SS_DownSites_History
		SELECT * INTO [SM_Change_Researching_DB].[dbo].[tbl_SS_DownSites_History]
			FROM [SM_Change_Researching_DB].[dbo].[tbl_SS_DownSites]
		*/
	}
		
?>					