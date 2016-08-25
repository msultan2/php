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
		$sql = "SELECT  CASE WHEN TT.Grade IN ('P1','P2','P3','P4') THEN  TT.Grade
					ELSE 'P4'
					END Severity, 
				CASE TT.Grade WHEN 'P1' THEN 1
							WHEN 'P2' THEN 2
							WHEN 'P3' THEN 3
							ELSE 4
					END Severity_Order, 
					COUNT(vio.Incident_ID) Violated_TTs,
					COUNT(*) Total_TT
				FROM dbo.vw_SS_Remedy_TT_SLA_Assigned TT
			    LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
			    ON TT.Incident_ID = vio.Incident_ID
				WHERE TT.Outage = 'No'
				GROUP BY CASE WHEN TT.Grade IN ('P1','P2','P3','P4') THEN  TT.Grade
					ELSE 'P4'
					END, 
					CASE TT.Grade WHEN 'P1' THEN 1
							WHEN 'P2' THEN 2
							WHEN 'P3' THEN 3
							ELSE 4
					END 
					ORDER BY 2;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		echo "<table><tr>";
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Severity']);
			array_push($data_Val,$row['Violated_TTs']);	
			
			echo "<td>".$row['Severity']."</td>
					<td width=120px>".$row['Violated_TTs']."</td>";
			echo "";
		}
		echo "</tr></table>";
		
		sqlsrv_free_stmt( $stmt);

		sqlsrv_close( $conn ); 
?>