<?php include ("index_tools.php");  ?>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<p> Down Sites with No TT<BR>

<?php
		$sumSites = 0;
		$sumTT = 0;
		$sumAreas = 0;
		
	/************************** Excel ***********************/

		$sql = "SELECT DISTINCT DS.Site_ID,DS.cellscount,DS.Node,CAST(DS.DownTime_StartDate AS VARCHAR) DownTime_StartDate,SS.Site_Type,CAST(DS.LastModified_Date AS VARCHAR) LastModified_Date,SS.Area,SS.Region,CASE WHEN TTnumber IS NULL THEN '(AFF) ' + AFF.Incident_ID WHEN AFF.Incident_ID IS NULL THEN '(RSV) ' + RSV.Incident_ID ELSE TTnumber END TTnumber, DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays, CAST(AFF.Outage_Site AS VARCHAR(MAX)) outage_parent_affectedSites ,AFF.SiteID outage_parent_siteID FROM dbo.tbl_SS_DownSites DS LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS ON SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID] ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50)) END ) LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT ON TT.Site_ID = DS.Site_ID LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT_Resolved RSV ON RSV.SiteID = DS.Site_ID LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT_Assigned AFF ON AFF.Outage_Site like '%'+DS.Site_ID+'%' WHERE TTnumber IS NULL AND SS.Site_ID IS NOT NULL;";		 
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",str_replace("+","_PLS_",$sql)));
		//echo $sql_encoded;
		echo '<a href="excel.php?name=SDS_nonTT&query='.$sql_encoded.'">';
		echo 'Export to Excel: <img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>';
	/************************** Excel ***********************/
	//5135-5195-5002
		echo "<div id='main'>
				<table class='features-table'>
				<tr>
					<td>Site ID</td>
					<td class='ol-cell col-cell1 col-cellh'>Type</td>
					<td class='ol-cell col-cell3 col-cellh'>Down Days</td>
					<td class='ol-cell col-cell2 col-cellh'>Down Time</td>
					<td class='ol-cell col-cell3 col-cellh'>Region</td>
					<td class='ol-cell col-cell2 col-cellh'>TTnumber</td>
					<td class='ol-cell col-cell3 col-cellh'>Parent Site</td>					
					<td class='ol-cell col-cell2 col-cellh'>Affected Site from Parent</td>
				</tr>";

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
				
				$sql = "SELECT DISTINCT DS.Site_ID,DS.cellscount,CASE WHEN DS.Urgency like '%TORE%' THEN 'Stores' WHEN DS.Urgency like 'NormaL' THEN 'Normal' ELSE DS.Urgency END Urgency,DS.Node,DS.DownTime_StartDate,SS.Site_Type,DS.LastModified_Date,SS.Area,SS.Region,
							CASE Request_Status WHEN 0 THEN 'Halt' WHEN 1 THEN 'Active' END Request_Status,
							HUB,CASE WHEN TTnumber IS NOT NULL 
							THEN TTnumber
						WHEN AFF.Incident_ID IS NOT NULL
							THEN '[AFF] ' + AFF.Incident_ID 
						 WHEN TTnumber IS NULL 
							THEN '[RSV] ' + RSV.Incident_ID 
							END TTnumber,CAST(SA_Time AS VARCHAR(50)) SA_Time,TT.Assigned_Team,TT.Chronic_Site,TT.Outage,TT.Site_Grade,
						DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays,
						CAST(AFF.Outage_Site AS VARCHAR(MAX)) outage_parent_affectedSites ,AFF.SiteID outage_parent_siteID
				  FROM dbo.tbl_SS_DownSites DS
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END )
				  LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT
				  ON  TT.Site_ID = DS.Site_ID
				  LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT_Resolved RSV
				  ON RSV.SiteID = DS.Site_ID	
				  LEFT OUTER JOIN dbo.vw_SS_Remedy_TT_SDS_Assigned AFF
				  ON AFF.Outage_Site like '%'+DS.Site_ID+'%'
				  LEFT OUTER JOIN [dbo].[tbl_SS_Remedy_TT_CellTask] tsk
				  ON DS.Site_ID = tsk.Site_ID AND tsk.Request_Status = 0
				  WHERE TTnumber IS NULL 
						AND SS.Site_ID IS NOT NULL
				ORDER BY DS.Site_ID;";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				$found = false;
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					$found = true;
					$Site_ID = $row['Site_ID'];
					$Site_Type = $row['Site_Type'];
					$Urgency = $row['Urgency'];
					$cellscount = $row['cellscount'];
					$LastModified_Date = $row['LastModified_Date'];
					$DownTime_StartDate = $row['DownTime_StartDate'];
					$Region = $row['Region'];
					$Area = $row['Area'];
					$TTnumber = $row['TTnumber'];
					$SA_Time = $row['SA_Time'];
					$Assigned_Team = $row['Assigned_Team'];
					$Chronic_Site = $row['Chronic_Site'];
					$Outage = $row['Outage'];
					$HUB = $row['HUB'];
					$Site_Grade = $row['Site_Grade'];
					$downDays = $row['downDays'];
					$Request_Status = $row['Request_Status'];
					$Outage_Parent_AffecSites = $row['outage_parent_affectedSites'];
					$Outage_Parent_siteID = $row['outage_parent_siteID'];
					
					$sumSites ++;
					if(strlen($TTnumber) > 0) $sumTT ++;
					
					//preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
					//$Impact = $Impact_Exp['impact_level'];
					//$is_Auth=($Authorized == 1)? 'checked':'';
					
					echo "<tr>
						<td>".$Site_ID."</td>
						<td class='col-cell col-cell1'>".$Site_Type."</td>
						<td class='col-cell col-cell3'>".$downDays."</td>
						<td class='col-cell col-cell1'>".$DownTime_StartDate."</td>
						<td class='col-cell col-cell3'>".substr($Area,0,33).", ".$Region."</td>
						<td class='col-cell col-cell1'>". ( ($TTnumber=="")? (($Request_Status==='Halt')? '<B>Requested to be Halted</B>':''):$TTnumber ) . "</td>
						<td class='col-cell col-cell3'><a href=index.php>".( (strlen($Outage_Parent_AffecSites)==0)? '<img src=images\cross.png width=16 height=16 alt=check>': ((strlen($Outage_Parent_AffecSites)>0)?'<img src=images\check.png width=16 height=16 alt=check>':'' ) )." ".$Outage_Parent_siteID."</a></td>		
						<td class='col-cell col-cell1'>".((strlen($Outage_Parent_AffecSites)>40)? substr($Outage_Parent_AffecSites,0,40)."..":$Outage_Parent_AffecSites) ."</td>";
					echo "</tr>";
				}
				if(!$found)
					echo "<tr><td class='col-cell col-cell1'>".$siteID."</td><td colspan=12 class='col-cell col-cell2'>Not found in the Database</td></tr>";
				
			sqlsrv_free_stmt( $stmt);
			//}
		
		
		echo "<tr class='no-border'>
						  <td></td>
						  <td class='col-cell col-cell1 col-cellf' colspan=3>Number of SDS: $sumSites</td>
						  <td class='col-cell col-cell3 col-cellf'></td>
						  <td class='col-cell col-cell1 col-cellf'>Number of TT: $sumTT</td>
						  <td class='col-cell col-cell3 col-cellf'></td>
						  <td class='col-cell col-cell2 col-cellf'></td>
						</tr>
				
				</table></div>";
	
		// Close the connection.
		sqlsrv_close( $conn );
	
?>		
<?php //include ("footer_tools.php");  ?>