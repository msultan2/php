<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	//error_reporting(-1);
	/* Parse configuration file */
	$ini_array = parse_ini_file("config.ini");

	/* Specify the server and connection string attributes. */

	$serverName = $ini_array['SERVER_NAME']; 
	$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);
		
	$fileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/MSC/HQ/Radio Cairo/Remedy/EXT-INT/Output.csv';
	$ScatteredSitesFile = file($fileName);
	$newFileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/SDS/Output_'.date('Ymd_Hi').'.txt';
		
	$ScatteredSitesDown = array();
	$sitesTT = array();
	
	$num_SS = count($ScatteredSitesFile);
	//echo "<U>Number of SDS: </U><B>".$num_SS."</B>";
	
	$i = 0;
	$DB_updated = false;
	while ($i < 10){
		$oldFileName = '//vf-eg.internal.vodafone.com/technology/TM/Service Management/SDS/Output_'.date('Ymd_Hi',time() - $i * 60).'.txt';
		if(file_exists($oldFileName)) {
			$DB_updated = true; 
			$oldFile = file($oldFileName);
			$num_SS = count($oldFile) ;
			echo "<U>Number of TT: </U><B> ".$num_SS."</B><BR>";
			list($site_ID,$fault,$Actual_Fault_Time,$Assigned_Team,$Discovered_Issue,$Site_Desc,$Node,$TTnumber,$location,$Affected_TRUs,$TRUs_No,$Outage,$Fault_Owner,$Status,$Region,$Sub_Region,$Assignee,$Assignment_Status,$Site_Grade,$Number_of_Cascades,$Reported_Date,$Service_Affecting_Time,$SiteVendor,$NumSites,$Chronic_Site,$Tier1,$HUB,$SiteType,$Tier3)=split("|",$oldFile[1],29);
			echo "Remedy File Already loaded on ".date('d-m-Y H:i',time() - $i * 60);

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT MAX(Reported_Date)	Modified
				FROM  dbo.tbl_SS_Remedy_TT;";
			$stmt = sqlsrv_query( $conn, $sql );
			if (sqlsrv_fetch($stmt)=== false){
				die( print_r( sqlsrv_errors(), true));
			}
			echo "Remedy File Already loaded on ".date('d-m-Y H:i',time() - $i * 60).".. last update: ".sqlsrv_get_field( $stmt, 0);
			sqlsrv_free_stmt( $stmt);
			sqlsrv_close( $conn ); 
			break;
		}
		$i++;
	}
	//"C:\Program Files (x86)\Google\Chrome\Application\chrome.exe" "http:\\egoct-witcm01\Rego\index.php"
	if (!file_exists($newFileName) && !$DB_updated) {
	
		for($index=0; $index < $num_SS ; $index++){	
		
			//list($site_ID,$fault,$Actual_Fault_Time,$Assigned_Team,$Discovered_Issue,$Site_Desc,$Node,$TTnumber,$location,$Affected_TRUs,$TRUs_No,$Outage,$Fault_Owner,$Status,$Region,$Sub_Region,$Assignee,$Assignment_Status,$Site_Grade,$Number_of_Cascades,$Reported_Date,$Service_Affecting_Time,$SiteVendor,$NumSites,$Chronic_Site,$Tier1,$HUB,$SiteType,$Tier3)=split("\t",$ScatteredSitesFile[$index],29);
			$pieces = explode("\t", $ScatteredSitesFile[$index]);
			//array_push($pieces,date('YYYY-mm-dd HH:ii:ss'));
			$dataString = implode("|", $pieces);
			//$pieces = explode("|", $arr);
			
			
			//$dataString = $site_ID.",".$fault.",".$Actual_Fault_Time.",".$Assigned_Team.",".$Discovered_Issue.",".$Site_Desc.",".$Node.",".$TTnumber.",,".$Affected_TRUs.",".$TRUs_No.",".$Outage.",".$Fault_Owner.",".$Status.",".$Region.",".$Sub_Region.",".$Assignee.",".$Assignment_Status.",".$Site_Grade.",".$Number_of_Cascades.",".$Reported_Date.",".$Service_Affecting_Time.",".$SiteVendor.",".$NumSites.",".$Chronic_Site.",".$Tier1.",".$HUB.",".$SiteType.",".$Tier3;
			//echo "<BR>$index<BR>".$dataString;
			file_put_contents($newFileName,$dataString, FILE_APPEND );
			//file_put_contents($newFileName,"\n", FILE_APPEND );
			
			array_push($sitesTT,$site_ID);
		}
		fclose($ScatteredSitesFile);
	
		//echo "<BR><U>Last Number of TTs: </U><B> ".$num_SS."</B>";
		list($site_ID,$fault,$Actual_Fault_Time,$Assigned_Team,$Discovered_Issue,$Site_Desc,$Node,$TTnumber,$location,$Affected_TRUs,$TRUs_No,$Outage,$Fault_Owner,$Status,$Region,$Sub_Region,$Assignee,$Assignment_Status,$Site_Grade,$Number_of_Cascades,$Reported_Date,$Service_Affecting_Time,$SiteVendor,$NumSites,$Chronic_Site,$Tier1,$HUB,$SiteType,$Tier3)=split("\t",$ScatteredSitesFile[0],29);
		//echo "<BR>Loading.. Last TT: ".$TTnumber;
		fclose($newFileName);
		
		$aggr_SS = count($sitesTT);
		
		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		
		if ($num_SS > 0) {
			$sql="TRUNCATE TABLE dbo.tbl_SS_Remedy_TT;";
			
			$stmt = sqlsrv_query( $conn, $sql);
			if( $stmt === false ) {
				die( print_r( sqlsrv_errors(), true));
			}
			
			sqlsrv_free_stmt( $stmt);
			
			$sql="BULK
					INSERT dbo.tbl_SS_Remedy_TT
					FROM '$newFileName'
					WITH
					(
					FIELDTERMINATOR = '|',
					ROWTERMINATOR = '\n',
					FIRSTROW=2
					)";
			$stmt = sqlsrv_query( $conn, $sql);
			if( $stmt === false ) {
				die( print_r( sqlsrv_errors(), true));
			}
			
			sqlsrv_free_stmt( $stmt);
			
			$sql_0 = "SELECT COUNT(DS.Site_ID) Down
				  FROM  dbo.tbl_SS_Remedy_TT SS
				  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END );";
			
			$sql = "SELECT MAX(Reported_Date)	Modified
				FROM  dbo.tbl_SS_Remedy_TT SS;";
			$stmt = sqlsrv_query( $conn, $sql );
			$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
			echo "Remedy TT file Last Modified: ".$row['Modified'];
			sqlsrv_free_stmt( $stmt);
		}
		sqlsrv_close( $conn ); 

	}

	
		
?>					