<link href="../css/style.css" rel="stylesheet" type="text/css" />
<?php	  
	error_reporting(-1);
		
	/* Parse configuration file */
		$ini_array = parse_ini_file("../config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}

$sql = "SELECT CONVERT(VARCHAR(24),MAX(cTimeStamp),100)Last_Updated_Time_Stamp FROM dbo.tbl_SS_Remedy_TT_Assigned;"; 
$stmt = sqlsrv_query( $conn, $sql );
$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
//print $row['Last_Updated_Time_Stamp'];
echo "<BR><U><B>Last Updated:     </U><B></B>".$row['Last_Updated_Time_Stamp']."</B><BR>";
echo "<U><B>Discmaimer: this SLA for Service Affecting only</B></U>";
											
sqlsrv_free_stmt( $stmt);		
sqlsrv_close( $conn ); 

?>	