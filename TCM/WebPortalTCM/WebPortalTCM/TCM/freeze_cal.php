<?php include ("template.php"); ?>
<div id="templatemo_content_wrapper">
	<div id="templatemo_content">
		<div id="main_content">

<?php
	//This part displays the resualt
	
			//phpinfo();
			error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
			
			/* Specify the server and connection string attributes. */
			$serverName = "egoct-wirws01"; //10.230.95.87
			$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");

			/* Connect using Windows Authentication. */
			$conn = sqlsrv_connect( $serverName, $connectionInfo);
			if( !$conn ) {
				 echo "Connection could not be established.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}
			$sql = "SELECT Occasion,[Freeze scope] as FScope,[Freeze period] as FPeriod
			FROM dbo.tbl_Freeze_Calendar" ;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=blue width=90% align=center >
					<tr>
						<th>Occasion/Event</th>
						<th>Freeze scope</th>
						<th>Freeze period</th>
					</tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$Occasion = $row['Occasion'];
				$Scope = $row['FScope'];
				$Period = $row['FPeriod'];
				
				echo "<tr>
					<td>".$Occasion."</td>
					<td>".$Scope."</td>
					<td>".$Period."</td>
					
				</tr>";
			}

			{echo "</table>";		
				
			sqlsrv_free_stmt( $stmt);
	
			// Close the connection;
			sqlsrv_close( $conn );
			}
			
?>

</div>
</div>
</div>
<?php include ("footer.php"); ?>