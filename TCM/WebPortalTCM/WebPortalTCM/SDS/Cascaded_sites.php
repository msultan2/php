<html><head>
<style type="text/css">
table.myTable { border-collapse:collapse; width:1200px; font-family: Arial; font-size:14;}
table.myTable th { color:darkred; background-color: white; text-align:left; width:200px;}
table.myTable td, table.myTable th { border:1px solid #eee;padding:5px;}
table.myTable td.CRQ, table.mytable th.CRQ {background-color:#eee;}
table.innerTable {width:100%;font-family: Arial; font-size:14;}
table.innerTable th {width:150px; color:black; }
table.innerTable th, table.innerTable td {border:none;}
</style>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
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
		<?php 
			$Site_ID = $_GET['site'];
			$sql = "SELECT  b.Site_ID, b.Code
				  FROM dbo.tbl_SS_Coded_Connectivity a
				  LEFT OUTER JOIN dbo.tbl_SS_Coded_Connectivity b
				  ON b.Code LIKE a.Code + '%'
				  WHERE a.Site_ID = '$Site_ID'";
				 
			//echo $sql;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			echo "<table class=myTable>";
			echo "<tr><th colspan=2>Coded Connectivity for Site: $Site_ID</th></tr>";
			echo "<tr><th class=CRQ>Site ID</th><th class=CRQ>Code</th></tr>";
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				echo "<tr><td>".$row['Site_ID']."</td><td>".$row['Code']."</td></tr>";
				
			}
			echo "</table>";
			sqlsrv_free_stmt( $stmt);
		?>

</body>
</html>
<?php sqlsrv_close( $conn ); ?>