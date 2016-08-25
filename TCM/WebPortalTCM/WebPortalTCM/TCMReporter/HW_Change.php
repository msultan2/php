<?php //session_start();  $pagePrivValue=10; require 'approve.php'; ?>
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
		$sql1 = "SELECT CRQ_TYPE,count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE Status NOT IN ('Draft','Request For Authorization')
				AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				GROUP BY CRQ_TYPE ORDER BY CRQ_TYPE;";
		$stmt = sqlsrv_query( $conn, $sql1 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_normal =0;
		$data_total = 0;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if ($row['CRQ_TYPE'] == 'Normal') $data_normal = $row['CRQnum'];
			$data_total += $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		
		$sql2 = "SELECT count(*) CRQnum FROM dbo.vw_Change_Approval_Details 
				WHERE Status NOT IN ('Draft','Request For Authorization')
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
		
		
		$sql3 = "SELECT inc.Dueto_Change,count(*) INCnum
				FROM dbo.tbl_Incident_TechIMReport inc
				WHERE inc.[Start Date] > '11/1/2012'
				GROUP BY inc.Dueto_Change;";
		$stmt = sqlsrv_query( $conn, $sql3 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_IDC =0;
		$data_Incidents = 0;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if ($row['Dueto_Change'] == '1') $data_IDC = $row['INCnum'];
			$data_Incidents += $row['INCnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		
		$sql4 = "SELECT ap.Product_Categorization_Tier_2 tier2, count(*) CRQnum FROM dbo.vw_Change_Approval_Details ap
				WHERE CRQ_TYPE = 'Normal' 
				AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND Status NOT IN ('Draft','Request For Authorization')
				AND Product_Categorization_Tier_2 IN ('SDP','Rollout & Expansions','Rollout','USSD','Corporate Website','CutOver')
				GROUP BY Product_Categorization_Tier_2;";
		$stmt = sqlsrv_query( $conn, $sql4 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}

		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if ($row['tier2'] == 'SDP') $data_tariffs = $row['CRQnum'];
			if ($row['tier2'] == 'Rollout & Expansions' OR $row['tier2']=='Rollout') $data_rollouts += $row['CRQnum'];
			if ($row['tier2'] == 'Corporate Website') $data_website = $row['CRQnum'];
			if ($row['tier2'] == 'CutOver') $data_CutOver = $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		
		$sql5 = "SELECT ap.Product_Categorization_Tier_1 tier, count(*) CRQnum FROM dbo.vw_Change_Approval_Details ap
				WHERE CRQ_TYPE = 'Normal' 
				AND Support_Company IN ('Regional Operations','Network Engineering','Products & Services Delivery','Service Management','IT Operations')
				AND Status NOT IN ('Draft','Request For Authorization')
				AND ( Product_Categorization_Tier_1 IN ('Fixed Network','Charging System','Prepaid Services','IN Configuration') 
				OR Product_Categorization_Tier_1 like 'TX%' )
				GROUP BY Product_Categorization_Tier_1;";
		$stmt = sqlsrv_query( $conn, $sql5 );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if ($row['tier'] == 'Fixed Network') $data_fixed = $row['CRQnum'];
			if (substr($row['tier'],0,2) == 'TX') $data_TX += $row['CRQnum'];
			if ($row['tier'] == 'Charging System' OR 
				$row['tier'] == 'Prepaid Services' OR
				$row['tier'] == 'IN Configuration') $data_prepaid += $row['CRQnum'];
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?>
	<font face="Mistral" size="4">
	<table >
		<tr><td><ul>Did you know that we have had since 12 August 2012 exactly:</td></tr>
		<tr><td><li> <b>235%</b> increase in the total number of Changes</li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_total)."</b> changes of which <b> ".number_format($data_normal)."</b> are non-standard."; ?> </li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_emergency)."</b> emergency changes";?>.</li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_Incidents)."</b> incidents of which <b> ".number_format($data_IDC)."</b> are incidents due to changes [since November 2012]";?>.</li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_tariffs)."</b> Tariff Updates.";?></li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_rollouts)."</b> Rollouts.";?></li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_CutOver)."</b> Cutovers.";?></li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_website)."</b> changes on the Corborate Website.";?></li></td></tr>
		<tr><td><li> <?php echo "<b> ".number_format($data_fixed)."</b> changes on the Fixed Networks, <b>".number_format($data_TX)."</b> changes on Transmission & <b>"
									.number_format($data_prepaid)."</b> changes on the Prepaid System.";?></li></td></tr>
	<tr>
	</tr></table>
	</font>
<?php include ("footer_new.php"); ?>