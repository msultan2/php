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

?>					