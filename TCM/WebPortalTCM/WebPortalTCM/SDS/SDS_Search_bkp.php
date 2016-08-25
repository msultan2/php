<?php include ("index_tools.php");  ?>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
		<table>
			<form action="SDS_Search.php" name="myForm" method="post">
				<tr>
					<td align=center valign=top><b>SDS Search: </b></td>
					<td align=left>
						<textarea wrap="hard" rows="10" cols="13" name="SiteIDs"><?php echo $_POST['SiteIDs'];?></textarea>
					</td>
					<td valign=top>
						<input type="submit" name="searchSDS" value="Search" />
					</td>
				</tr>
				<tr style="height:10px"></tr>
			</form>		
		</table>		

<?php
	//This part displays the Search CRQ result
	if (isset($_POST['SiteIDs'])) {
	
		$SiteIDs = preg_split('/\n/',$_POST['SiteIDs']);
		$arrArea = array();
		$sumSites = 0;
		$sumTT = 0;
		$sumAreas = 0;
		
	/************************** Excel ***********************/
	$querySDS = "";
	for ($i=0; $i<sizeof($SiteIDs); $i++){
		$querySDS = $querySDS. "'$SiteIDs[$i]'";
		if($i < sizeof($SiteIDs) - 1)
			$querySDS = $querySDS. ",";
	}
		$sql = "SELECT DS.Site_ID,DS.cellscount,CASE WHEN DS.Urgency like '%TORE%' THEN 'Stores' WHEN DS.Urgency like 'NormaL' THEN 'Normal' ELSE DS.Urgency END Urgency,DS.Node,DS.DownTime_StartDate,SS.Site_Type,DS.LastModified_Date,SS.Area,SS.Region,HUB,TTnumber,CAST(SA_Time AS VARCHAR(50)) SA_Time,TT.Assigned_Team,TT.Chronic_Site,TT.Outage,TT.Site_Grade,DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays FROM dbo.tbl_SS_DownSites DS LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS ON SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID] ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50)) END ) LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT ON TT.Site_ID = SS.Site_ID WHERE SS.Site_ID IN ($querySDS);";		 
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",$sql));
		//echo $sql_encoded;
		echo '<a href="excel.php?name=SDS_2014&query='.$sql_encoded.'">';
		echo 'Export to Excel: <img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>';
	/************************** Excel ***********************/
	
		echo "<div id='main'>
				<table class='features-table'>
				<tr>
					<td>Site ID</td>
					<td class='ol-cell col-cell1 col-cellh'>Type</td>
					<td class='ol-cell col-cell2 col-cellh'>Urgency</td>
					<td class='ol-cell col-cell3 col-cellh'>Down Days</td>
					<td class='ol-cell col-cell2 col-cellh'>Down Time</td>
					<td class='ol-cell col-cell2 col-cellh'>Area</td>
					<td class='ol-cell col-cell3 col-cellh'>Region</td>
					<td class='ol-cell col-cell2 col-cellh'>HUB</td>
					<td class='ol-cell col-cell2 col-cellh'>TTnumber</td>
					<td class='ol-cell col-cell3 col-cellh'>Assigned Team</td>
					<td class='ol-cell col-cell2 col-cellh'>Chronic</td>
					<td class='ol-cell col-cell3 col-cellh'>Outage</td>
					<td class='ol-cell col-cell2 col-cellh'>P</td>
				</tr>";
		for ($i=0; $i<sizeof($SiteIDs); $i++){
		
			$siteID=chop($SiteIDs[$i]);
			//if(strlen($siteID) >6 OR strlen($siteID) <5 OR !is_numeric($siteID)){
			//	echo "<tr><td>".$siteID."</td><td colspan=11>Not a valid number, please enter the last 5 digits in the CRQ Number</td></tr>";
			//}
			//else{ 
					
			//phpinfo();
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
				if(strlen($siteID) == 0) continue;
				if(strlen($siteID) == 2) $siteID_4d="00".$siteID;
				else if(strlen($siteID) == 3) $siteID_4d="0".$siteID;
				else $siteID_4d = $siteID;
				
				$sql = "SELECT DS.Site_ID,DS.cellscount,CASE WHEN DS.Urgency like '%TORE%' THEN 'Stores' WHEN DS.Urgency like 'NormaL' THEN 'Normal' ELSE DS.Urgency END Urgency,DS.Node,DS.DownTime_StartDate,SS.Site_Type,DS.LastModified_Date,SS.Area,SS.Region,HUB,TTnumber,CAST(SA_Time AS VARCHAR(50)) SA_Time,TT.Assigned_Team,TT.Chronic_Site,TT.Outage,TT.Site_Grade,
						DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays
				  FROM dbo.tbl_SS_DownSites DS
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END )
				  LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT
				  ON  TT.Site_ID = SS.Site_ID
				  WHERE SS.Site_ID = '".$siteID_4d."';";
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				$found = false;
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					$found = true;
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
					
					
					$sumSites ++;
					if(strlen($TTnumber) > 0) $sumTT ++;
					array_push($arrArea,$Area);
					//preg_match('/(?P<x>\d+)-(?P<impact_level>\w+)\/(?P<y>\w+)/', $row['Impact'],$Impact_Exp);
					//$Impact = $Impact_Exp['impact_level'];
					//$is_Auth=($Authorized == 1)? 'checked':'';
					
					echo "<tr>
						<td>".$siteID_4d."</td>
						<td class='col-cell col-cell1'>".$Site_Type."</td>
						<td class='col-cell col-cell2'>".$Urgency."</td>
						<td class='col-cell col-cell3'>".$downDays."</td>
						<td class='col-cell col-cell1'>".$DownTime_StartDate."</td>
						<td class='col-cell col-cell1'>".substr($Area,0,33)."</td>
						<td class='col-cell col-cell3'>".$Region."</td>
						<td class='col-cell col-cell1'>".$HUB."</td>						
						<td class='col-cell col-cell1'>". ( ($TTnumber=="")? '':$TTnumber ) . "</td>
						<td class='col-cell col-cell3'>".substr($Assigned_Team,0,33)."</td>
						<td class='col-cell col-cell1'>".( ($Chronic_Site==="No")? '<img src=images\cross.png width=16 height=16 alt=check>': (($Outage==="Yes")?'<img src=images\check.png width=16 height=16 alt=check>':'' ) )."</td>
						<td class='col-cell col-cell3'>".( ($Outage==="N")? '<img src=images\cross.png width=16 height=16 alt=check>': (($Outage==="Y")?'<img src=images\check.png width=16 height=16 alt=check>':'' ) )."</td>
						<td class='col-cell col-cell1'>".$Site_Grade."</td>";
					echo "</tr>";
				}
				if(!$found)
					echo "<tr><td class='col-cell col-cell1'>".$siteID."</td><td colspan=12 class='col-cell col-cell2'>Not found in the Database</td></tr>";
				
			sqlsrv_free_stmt( $stmt);
			//}
		}
		$sumAreas = count(array_unique($arrArea));
		echo "<tr class='no-border'>
						  <td></td>
						  <td class='col-cell col-cell1 col-cellf' colspan=4>Number of SDS: $sumSites</td>
						  <td class='col-cell col-cell1 col-cellf'>Areas: $sumAreas</td>
						  <td class='col-cell col-cell3 col-cellf'></td>
						  <td class='col-cell col-cell1 col-cellf'></td>
						  <td class='col-cell col-cell1 col-cellf'>Number of TT: $sumTT</td>
						  <td class='col-cell col-cell3 col-cellf'></td>
						  <td class='col-cell col-cell1 col-cellf'></td>
						  <td class='col-cell col-cell3 col-cellf'></td>
						  <td class='col-cell col-cell2 col-cellf'></td>
						</tr>
				
				</table></div>";
	
		// Close the connection.
		sqlsrv_close( $conn );
	}
?>		
<?php //include ("footer_tools.php");  ?>