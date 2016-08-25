<?php
		
		$weekback = date('m/d/Y', time() + (60 * 60 * 24 * -7));
		$yesterday = date('m/d/Y', time() + (60 * 60 * 24 * -1));
		//echo $weekback." ".$yesterday;

		if(isset($_GET['from'])) $getFrom = $_GET['from']; else $getFrom = $weekback;
		if(isset($_GET['to'])) $getTo = $_GET['to']; else $getTo = $yesterday;
	
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
		$sql1 = "SELECT count(*) CRQ_Total
				FROM dbo.tbl_Change_Approval_Details
				WHERE dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				--AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND Status NOT IN ('Draft','Request For Authorization');";
		$stmt = sqlsrv_query( $conn, $sql1 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_total = 0;
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		$data_total = sqlsrv_get_field( $stmt, 0);
		sqlsrv_free_stmt( $stmt);
		
		
		$sql2 = "SELECT count(*) 
				FROM dbo.tbl_Change_Approval_Details
				WHERE dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				--AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND Status NOT IN ('Draft','Request For Authorization')
				AND Emergency = 0;";
		$stmt = sqlsrv_query( $conn, $sql2 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_emergency =0;
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		$data_emergency = sqlsrv_get_field( $stmt, 0);
		
		sqlsrv_free_stmt( $stmt);
		
		
		$sql3 = "SELECT count(*) 
				FROM dbo.tbl_Change_Approval_Details
				WHERE dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				--AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND Status NOT IN ('Draft','Request For Authorization')
				AND CRQ_Type = 'Normal';";
		$stmt = sqlsrv_query( $conn, $sql3 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_normal =0;
		if (sqlsrv_fetch($stmt)=== false){
			die( print_r( sqlsrv_errors(), true));
		}
		$data_normal = sqlsrv_get_field( $stmt, 0);
		sqlsrv_free_stmt( $stmt);
		
		
		sqlsrv_close( $conn );
?>
	<font face="Verdana" size="4">
	<table >
		<tr><td><li>Total Authorized Changes:  <?php echo "<b> ".number_format($data_total)."</b> of which <b> ".number_format($data_normal)."</b> are Non-Standard"; ?> </li></td></tr>
		<tr><td><li>Total Emergency Changes: <?php echo "<b> ".number_format($data_emergency)."</b> Emergency changes";?>.</li></td></tr>
	<tr>
	</tr></table>
	</font>