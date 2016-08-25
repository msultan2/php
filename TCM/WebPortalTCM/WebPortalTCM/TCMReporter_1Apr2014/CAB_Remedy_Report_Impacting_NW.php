<?php session_start();  $pagePrivValue=20; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
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
?>
<table><tr>
		<td>
		<div class="body_text"><b>Remedy Query</b></div><BR>
		</td>
	</tr>
	<tr><td><textarea name="query" cols="125" rows="25">
		<?php 
			$sql = "SELECT DISTINCT CRQ 
					FROM dbo.vw_Change_Tomorrow_CAB 
					WHERE status = 'Request For Authorization' 
						AND (External_Customer IS NOT NULL OR Internal_Customer IS NOT NULL OR Nodes_Systems IS NOT NULL OR Reporting IS NOT NULL
						OR Service_Impact  IS NOT NULL OR Business_Impact IS NOT NULL OR Technical_Impact IS NOT NULL OR DWH_Impact IS NOT NULL);";
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			$count=0;
			$arrCRQ = array();
			$strCRQ = '';
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				//array_push($arrCRQ, $row['CRQ']);
				if ($count == 0) 
					$strCRQ = "'Status*' = ".'"Request For Authorization"'. " AND 'Change For' = ".'"Network"'." AND ( 'Change ID*+' = ".'"'. $row['CRQ'] .'" ';
				else
					$strCRQ .= " OR 'Change ID*+' = ".'"'. $row['CRQ'] .'" ';
				$count++;
			}
			if ($count > 0)
				$strCRQ .= ")";
			//$strCRQ = implode(",",$arrCRQ);
			echo $strCRQ;
			sqlsrv_free_stmt( $stmt);
		?>
		</textarea>
		</td></tr>
</table>
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>