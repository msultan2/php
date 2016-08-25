<?php include ("newtemplate.php"); ?>
CAB Attendance For Today: <?php echo date('d-m-Y'); ?>
<?php

			// get the file contents, assuming the file to be readable (and exist) 
			$contents = file_get_contents($CRQfile); 
				
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
				
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "Database"=>$ini_array['DB_NAME']);

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT team.Team_Name,team.Team_Department,lk_att.Attendance_Description,att.CM_Comment 
					FROM dbo.tbl_Change_Daily_CAB_Attendance att, dbo.tbl_Change_Daily_CAB_Teams team, dbo.tbl_Change_Daily_CAB_LK_Attendance lk_att
					WHERE att.Team_ID = team.Team_ID 
					AND att.Attendance_ID = lk_att.Attendance_ID;";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=red width=50% >
					<tr>
						<th>Team</th>
						<th>Department</th>
						<th>Attendance</th>
						<th>CM Comment</th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$Team_Name = $row['Team_Name'];
				$CM_Comment = $row['CM_Comment'];
				$Attendance_Description = $row['Attendance_Description'];
				$Team_Department = $row['Team_Department'];
				
				echo "<tr>
						<td>".$Team_Name."</td>
						<td>".$Team_Department."</td>
						<td>".$Attendance_Description."</td>
						<td>".$CM_Comment."</td>
					</tr>";
			}

			echo "</table>";

	sqlsrv_free_stmt( $stmt);
	
	// Close the connection.
	sqlsrv_close( $conn );
?>		
	
<?php include ("footer_new.php"); ?>