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
				FROM dbo.vw_Change_Approval_Details
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
				FROM dbo.vw_Change_Approval_Details ch
				LEFT OUTER JOIN dbo.vw_Change_Approvers_Merged ap ON ch.CRQ = ap.Infrastructure_Change_ID 
				WHERE dbo.DateOnly(Scheduled_Start_Date) <= '$getTo' AND dbo.DateOnly(Scheduled_Start_Date) >= '$getFrom'
				AND CRQ_Type = 'Normal'
				AND Status NOT IN ('Draft','Request For Authorization')
				AND (
						(( ch.Scheduled_Start_Date < '1/10/2014' AND	DATEADD(day, -DATEDIFF(day, 0, [First Approval Date]), [First Approval Date]) > '2:00:00 PM' 
							AND dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
						) 
						OR  
						(	ch.Scheduled_Start_Date >= '1/10/2014' AND 
							(dbo.DATEONLY( [First Approval Date]) >= dbo.DATEONLY( dbo.udf_GetPrevNextWorkDay(ch.Scheduled_Start_Date, 'Previous'))   
							AND NOT DATEADD(day, -DATEDIFF(day, 0, ch.Scheduled_Start_Date), ch.Scheduled_Start_Date) > '3:00:00 PM' 
							)  
							AND ap.[Approval Aduit Trail] like '%CM_Authorized%'
						)
					)
					OR    ( Emergency IN (2,3,0) ) ) 
				AND NOT (Description LIKE ('%fix%') OR Justification LIKE ('%fix%') OR Description LIKE ('%problem%') OR Justification LIKE ('%problem%') OR Description LIKE ('%solve%') OR Justification LIKE ('%solve%')) ;";
		//echo $sql;
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
				FROM dbo.vw_Change_Approval_Details
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