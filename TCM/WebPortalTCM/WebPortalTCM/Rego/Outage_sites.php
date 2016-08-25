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
			$sql = "SELECT AFF.SiteID, CAST(AFF.Outage_Site AS VARCHAR(MAX)) outage_parent_affectedSites,AFF.Assigned_Group, AFF.No_Transfers,
						AFF.Assigment_Status, CAST(AFF.Assigned_Date AS VARCHAR) Assigned_Date, AFF.Categorization_Tier_1, Area, SS.Region, Incident_ID,
						AFF.Categorization_Tier_1, Area,SS.Region,CAST(AFF.last_modified_date AS VARCHAR) last_modified_date,CAST(AFF.Start_Date AS VARCHAR) Start_Date,AFF.Status,CAST(AFF.[Submit Date] AS VARCHAR) Submit_Date
				  FROM dbo.tbl_SS_Remedy_TT_Assigned AFF
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN AFF.SiteID LIKE '%[a-z]%' THEN AFF.SiteID
													ELSE cast(CAST(AFF.SiteID as int) as nvarchar(50))
													END )
				  WHERE AFF.SiteID = '$Site_ID'";
				 
			//echo $sql;
			$stmt = sqlsrv_query( $conn, $sql );
			if( $stmt === false) {
				die( print_r( sqlsrv_errors(), true) );
			}
			
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				echo "<table class=myTable>";
				echo "<tr><th class=CRQ>Site ID</th><td class=CRQ>".$Site_ID."</td></tr>";
				echo "<tr><th>Area</th><td>".$row['Area']." ( ".$row['Region']." )</td></tr>";
				echo "<tr><th>Affected Sites</th><td>".$row['outage_parent_affectedSites']."</td></tr>";
				echo "<tr><th>TT Categorization Tier</th><td>".$row['Categorization_Tier_1']."</td></tr>";
				echo "<tr><th>TT (Status)</th><td>".$row['Incident_ID']." ( ".$row['Status']." )</td></tr>";
				echo "<tr><th>Submit Date</th><td>".$row['Submit_Date']."</td></tr>";
				echo "<tr><th>Start Date</th><td>".$row['Start_Date']."</td></tr>";
				echo "<tr><th>Last Modified Date</th><td>".$row['last_modified_date']."</td></tr>";
				echo "<tr><th>Assigned Date</th><td>".$row['Assigned_Date']."</td></tr>";
				echo "<tr><th>Assigned Team</th><td><B>".$row['Assigned_Group']."</B></td></tr>";
				echo "<tr><th>Assigned Status</th><td>".$row['Assigment_Status']."</td></tr>";
				echo "<tr><th>Number of Hops</th><td>".$row['No_Transfers']."</td></tr>";
				echo "</table>";
			}
			
			sqlsrv_free_stmt( $stmt);
		?>

</body>
</html>
<?php sqlsrv_close( $conn ); ?>