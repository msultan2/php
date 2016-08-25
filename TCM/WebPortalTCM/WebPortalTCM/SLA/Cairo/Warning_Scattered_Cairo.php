<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("../config.ini");

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
		$sql = "SELECT  COUNT(*)Warning
				  FROM dbo.vw_SS_Remedy_TT_SLA_All TT
				  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				  ON TT.Incident_ID = vio.Incident_ID
				  WHERE TT.Outage = 'No'
				  AND TT.Region like '%Cairo%'
				  AND TT.SLM_Status < =2
				  AND TT.Status not like '%Resolved%'
				  GROUP BY TT.Outage;";
  
		$stmt = sqlsrv_query( $conn, $sql );

		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Warning =  array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data_Warning = $row['Warning'];
			array_push($data_Warning,$row['Warning']);			
			}
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn );



?>
<table>
<tr>
<td>
<h3>
<a href="Warning_Outages_Links.php" target='_blank'><B>Warning... 
<?php 
if ($data_Warning != NULL ){
echo "$data_Warning";
}
else if ($data_Warning == '' ) {
echo 0;
}

?> TTs approaching SLA!</B></a>
</h3>
</td>
</tr>
</table>




