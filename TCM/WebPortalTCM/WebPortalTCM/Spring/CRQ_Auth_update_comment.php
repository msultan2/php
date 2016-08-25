<?php
	$myFile = "txt/auth.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = 	date('d-m-Y H:i:s')						." | ". 
					$_SERVER['REMOTE_ADDR']					." | ". 
					gethostbyaddr($_SERVER['REMOTE_ADDR']) 	." | ".
					$_SERVER['PHP_SELF'];
	

	error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
	
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
		 echo "Connection could not be established.<br />";
		 die( print_r( sqlsrv_errors(), true));
	}
	$CRQ = $_GET['updateCRQ'];
	//$if_Auth = intval($_GET['updateAuth']);
	$new_comment = str_replace("-", " ", $_GET['new_comment']);


	$sql = "SELECT COUNT(*) FROM dbo.tbl_Change_Daily_CAB_Authorize WHERE CRQ = '".$CRQ."';";
	$stringData = $stringData . "|" . $CRQ ."|new_comment=".$new_comment;
	
	$dup = sqlsrv_query($conn, $sql);
	if (sqlsrv_fetch($dup)=== false){
		die( print_r( sqlsrv_errors(), true));
	}

	$numof_CRQs = sqlsrv_get_field( $dup, 0);
	if( $numof_CRQs > 0)
	{
		//Already Exists
		$sql = "UPDATE dbo.tbl_Change_Daily_CAB_Authorize SET CM_Comment = '".$new_comment."' WHERE CRQ = '".$CRQ."';";
		sqlsrv_query( $conn, $sql);
		//sqlsrv_free_stmt( $stmt);
		echo $sql."updated";
		$stringData = $stringData . "|updated";
	}
	else
	{
		 $sql = "INSERT INTO dbo.tbl_Change_Daily_CAB_Authorize (CRQ , Authorized, CM_Comment, User_Updating, Auth_Date)
					VALUES ('".$CRQ."',0,'".$new_comment."','not me', '". date('m/d/Y H:i:s')."' );";
		 sqlsrv_query( $conn, $sql);
		 echo "inserted";
		 $stringData = $stringData . "|inserted";
	}
	
	fwrite($fh, $stringData. "\r\n");
	fclose($fh);

	sqlsrv_free_stmt( $dup);
	// Close the connection.
	sqlsrv_close( $conn );
	
?>		