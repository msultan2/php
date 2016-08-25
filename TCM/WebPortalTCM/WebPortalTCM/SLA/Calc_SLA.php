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
		$sql = "SELECT COUNT(vio.Incident_ID) Violated_TTs,COUNT(TT.Incident_ID) Total_TTs
					FROM dbo.vw_SS_Remedy_TT_SLA_All TT
				  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				  ON TT.Incident_ID = vio.Incident_ID;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Val_Outage = 0;
		$data_Val_Scattered = 0;
		$Total_scattered = 0;
		$Total_outage = 0;
		$Percent = 100 - 80;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$SLA_Coverage = 100 - round(($row['Violated_TTs']/$row['Total_TTs'])*100 ,0); 
		}
		
		sqlsrv_free_stmt( $stmt);
		
		
		/* Services SLA */
		$sql = "SELECT  COUNT(vio.Incident_ID) Violated_TT , COUNT(*) Total_TT
				  FROM dbo.[vw_SS_Remedy_TT_SLA_Assigned_Services] TT
				  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Services_Violated] vio
				  ON TT.Incident_ID = vio.Incident_ID;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Val_Outage = 0;
		$data_Val_Scattered = 0;
		$Total_scattered = 0;
		$Total_outage = 0;
		$Percent = 100 - 80;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$SLA_Services = 100 - round(($row['Violated_TT']/$row['Total_TT'])*100 ,0); 
		}
		
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?>