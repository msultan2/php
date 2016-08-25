<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  
	error_reporting(-1);
		
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
		$sql = "SELECT COUNT(DS.Site_ID) Down
				  FROM  dbo.tbl_SS_DownSites DS 
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END );";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
		echo "<BR><U>Number of SDS: </U><B>".$row['Down']."</B>";
		sqlsrv_free_stmt( $stmt);
		
		$sql0 = "SELECT CONVERT(VARCHAR(24),MAX(dbo.fn_RotateDays_InDate(LastModified_Date)),100) LastUpdate
				  FROM  dbo.tbl_SS_DownSites;";
				  
		$sql = "SELECT MAX(LastModified_Date) LastUpdate
				  FROM  dbo.tbl_SS_DownSites;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
		echo "<BR>Last updated: ".$row['LastUpdate'];
		sqlsrv_free_stmt( $stmt);
		
		$sql = "SELECT COUNT(DS.Site_ID) Down
				  FROM  dbo.tbl_SS_Remedy_TT TT
				  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				  ON  TT.Site_ID = DS.[Site_ID];";
			
		$stmt = sqlsrv_query( $conn, $sql );
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
		echo "<BR><U>Number of TT: </U><B>".$row['Down']."</B>";
		sqlsrv_free_stmt( $stmt);
		
		$sql = "SELECT CONVERT(VARCHAR(24),MAX(Reported_Date),100) Modified
			FROM  dbo.tbl_SS_Remedy_TT ;";
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
		echo "<BR>Last Updated: ".$row['Modified'];
		sqlsrv_free_stmt( $stmt);
			
		sqlsrv_close( $conn ); 
		
	
		
?>					