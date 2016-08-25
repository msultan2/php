        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
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
		$sql = "SELECT  CASE WHEN TT.Grade IN ('P1','P2','P3','P4') THEN  TT.Grade
					ELSE 'P4'
					END Severity, 
				CASE TT.Grade WHEN 'P1' THEN 1
							WHEN 'P2' THEN 2
							WHEN 'P3' THEN 3
							ELSE 4
					END Severity_Order, 
					COUNT(vio.Incident_ID) Violated_TTs,
					COUNT(*) Total_TT
				FROM dbo.vw_SS_Remedy_TT_SLA_Assigned TT
			    LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
			    ON TT.Incident_ID = vio.Incident_ID
				WHERE TT.Outage = 'No'
				GROUP BY CASE WHEN TT.Grade IN ('P1','P2','P3','P4') THEN  TT.Grade
					ELSE 'P4'
					END, 
					CASE TT.Grade WHEN 'P1' THEN 1
							WHEN 'P2' THEN 2
							WHEN 'P3' THEN 3
							ELSE 4
					END 
					ORDER BY 2;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_Val_Total = array();
		$data_Val_Per = array();
		$data_Val[P1] = 0;
		$data_Val[P2] = 0;
		$data_Val[P3] = 0;
		$data_Val[P4] = 0;
		//echo "<table><tr>";
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Desc,$row['Severity']);
			//array_push($data_Val,$row['Violated_TTs']);	
			if($row['Severity'] == 'P1') { 
				$data_Val[P1] = $row['Violated_TTs'];
				$data_Val_Total[P1] = $row['Total_TT'];
				$data_Val_Per[P1] = round(($data_Val[P1] / $data_Val_Total[P1])*100 ,0);
			}
			else if($row['Severity'] == 'P2') { 
				$data_Val[P2] = $row['Violated_TTs'];
				$data_Val_Total[P2] = $row['Total_TT'];
				$data_Val_Per[P2] = round(($data_Val[P2] / $data_Val_Total[P2])*100 ,0);
			}
			else if($row['Severity'] == 'P3') { 
				$data_Val[P3] = $row['Violated_TTs'];
				$data_Val_Total[P3] = $row['Total_TT'];
				$data_Val_Per[P3] = round(($data_Val[P3] / $data_Val_Total[P3])*100 ,0);
			}
			else if($row['Severity'] == 'P4') { 
				$data_Val[P4] = $row['Violated_TTs'];
				$data_Val_Total[P4] = $row['Total_TT'];
				$data_Val_Per[P4] = round(($data_Val[P4] / $data_Val_Total[P4])*100 ,0);
			}
			//echo "<td>".$row['Severity']."</td><td width=120px>".$row['Violated_TTs']."</td>";
		}
		//echo "</tr></table>";
		
		sqlsrv_free_stmt( $stmt);

		sqlsrv_close( $conn ); 
?>
<div class="box box-solid">
	<div class="box-header">
		<h3 class="box-title">Compliance %</h3>
	</div><!-- /.box-header -->
	<div class="box-body text-center">
		P1
		<div class="progress progress-striped vertical">
			<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $data_Val_Per[P1]; ?>%">
				<span><?php echo $data_Val_Per[P1]; ?>%</span>
			</div>
		</div>
		P2
		<div class="progress progress-striped vertical">
			<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $data_Val_Per[P2]; ?>%">
				<span ><?php echo $data_Val_Per[P2]; ?>%</span>
			</div>
		</div>
		P3
		<div class="progress progress-striped vertical">
			<div class="progress-bar progress-bar-yellow-p" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $data_Val_Per[P3]; ?>%">
				<span><?php echo $data_Val_Per[P3]; ?>%</span>
			</div>
		</div>
		P4
		<div class="progress progress-striped vertical">
			<div class="progress-bar progress-bar-navy" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $data_Val_Per[P4]; ?>%">
				<span><?php echo $data_Val_Per[P4]; ?>%</span>
			</div>
		</div>		
	</div><!-- /.box-body -->
</div><!-- /.box -->