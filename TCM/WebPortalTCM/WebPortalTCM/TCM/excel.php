<?php
	function cleanData(&$str)
	  {
		if($str == 't') $str = 'TRUE';
		if($str == 'f') $str = 'FALSE';
		if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
		  $str = "'$str";
		}
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	  }

		// Here add your own data for connecting to MySQL database
		$serverName = 'egzhr-wie2e01';
		$connectionInfo = array( "Database"=>"SM_Change_Researching_DB");
	
	/* Connect using Windows Authentication. */
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
	 
	$flag = false;
	$report_name=$_GET['name'];
	$sql_encoded=$_GET['query'];
	$sql = str_replace("|"," ",str_replace("__EQUAL__","=",$sql_encoded));
	//echo $sql;
	//echo $sql_encoded;
	 // filename for download
	$filename = "Veto_data_".$report_name."_"	. date('Ymd') . ".csv";

	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: text/csv;");

	$out = fopen("php://output", 'w');
	
	$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if(!$flag) {
				fputcsv($out, array_keys($row), ',', '"');
				$flag = true;
			}
			array_walk($row);
			fputcsv($out, array_values($row), ',', '"');
		}
		
	sqlsrv_free_stmt( $stmt);
	
	sqlsrv_close( $conn ); 
		

  fclose($out);
  exit;
?>