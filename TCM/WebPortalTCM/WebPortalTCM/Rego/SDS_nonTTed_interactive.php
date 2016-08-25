<?php include ("index_tools.php");  ?>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<p> Down Sites with No TT<BR>

<?php
	$sumSites = 0;
	$sumTT = 0;
	$affSites = 0;
	
	$data_Desc = array();
	$data_Val = array();
	$data_siteType = array();
	$data_downDate = array();
	$data_siteUrgency = array();
	$data_siteCells = array();
	$data_siteTRU = array();
	$data_siteNode = array();
	$data_modifiedDate = array();
	$data_area = array();
	$data_region = array();
	$data_Halt = array();
	$data_TT = array();
	$data_SA_Time = array();
	$data_Assigned_Team = array();
	$data_Chronic_Site = array();
	$data_Outage = array();
	$data_HUB = array();
	$data_Site_Grade = array();
	$Outage_Parent_AffecSites = array();
	$Outage_Parent_siteID = array();
	$Number_of_Cascaded = array();
	
	/************************** Excel ***********************/
		
		$sql = "SELECT DISTINCT DS.Site_ID,DS.cellscount,DS.Node,TRUCount TRU_Num,CAST(DS.DownTime_StartDate AS VARCHAR) DownTime_StartDate,SS.Site_Type,CAST(DS.LastModified_Date AS VARCHAR) LastModified_Date,SS.Area,SS.Region,CASE WHEN TTnumber IS NULL THEN '(AFF) ' + AFF.Incident_ID WHEN AFF.Incident_ID IS NULL THEN '(RSV) ' + RSV.Incident_ID ELSE TTnumber END TTnumber, DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays, CAST(AFF.Outage_Site AS VARCHAR(MAX)) outage_parent_affectedSites ,AFF.SiteID outage_parent_siteID FROM dbo.tbl_SS_DownSites DS LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS ON SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID] ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50)) END ) LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT ON TT.Site_ID = DS.Site_ID LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT_Resolved RSV ON RSV.SiteID = DS.Site_ID LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT_Assigned AFF ON AFF.Outage_Site like '%'+DS.Site_ID+'%' WHERE TTnumber IS NULL AND SS.Site_ID IS NOT NULL;";		 
		$sql_encoded = str_replace(" ","|",str_replace("=","__EQUAL__",str_replace("+","_PLS_",$sql)));
		//echo $sql_encoded;
		echo '<a href="excel.php?name=SDS_nonTT&query='.$sql_encoded.'">';
		echo 'Export to Excel: <img width=24px height=24px src="images/excel.bmp" style="border-style: none"/></a>';
	/************************** Excel ***********************/

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
				$TRU_0='"0"';
				$sql = "SELECT DISTINCT DS.Site_ID,DS.cellscount,DS.Node,CASE TRUCount WHEN '$TRU_0' THEN 0 ELSE TRUCount END TRU_Num,CASE WHEN DS.Urgency like '%TORE%' THEN 'Stores' WHEN DS.Urgency like 'NormaL' THEN 'Normal' ELSE DS.Urgency END Urgency,DS.Node,DS.DownTime_StartDate,SS.Site_Type,DS.LastModified_Date,SS.Area,
							CASE SS.Region WHEN 'Upper Egypt' THEN 'Upper'
											WHEN 'Alexandria' THEN 'Alex'
											ELSE SS.Region
								END Region,
							CASE Request_Status WHEN 0 THEN 'Halt' WHEN 1 THEN 'Active' END Request_Status,
							dbo.Cascaded_sites(CC.Code) Number_of_Cascaded,
							HUB,
							CASE WHEN TTnumber IS NOT NULL 
									THEN TTnumber
								WHEN AFF.Incident_ID IS NOT NULL
									THEN '[AFF] ' + AFF.Incident_ID 
								WHEN TTnumber IS NULL 
									THEN '[RSV] ' + RSV.Incident_ID 
							END TTnumber,
							CASE WHEN TTnumber IS NOT NULL 
									THEN CAST(SA_Time AS VARCHAR(50))
								WHEN TTnumber IS NULL 
									THEN '[RSV] ' + CAST(RSV.[Last Resolved Date] AS VARCHAR(50))
							END SA_Time,TT.Assigned_Team,TT.Chronic_Site,TT.Outage,TT.Site_Grade,
						DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays,
						CAST(AFF.Outage_Site AS VARCHAR(MAX)) outage_parent_affectedSites ,AFF.SiteID outage_parent_siteID
				  FROM dbo.tbl_SS_DownSites DS
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END )
				  LEFT OUTER JOIN dbo.tbl_SS_Coded_Connectivity CC
				  ON  CC.Site_ID = DS.Site_ID
				  LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT
				  ON  TT.Site_ID = DS.Site_ID
				  LEFT OUTER JOIN dbo.vw_SS_Remedy_TT_SDS_Resolved RSV
				  ON RSV.SiteID = DS.Site_ID	
				  LEFT OUTER JOIN dbo.vw_SS_Remedy_TT_SDS_Assigned AFF
				  ON AFF.Outage_Site like '%'+DS.Site_ID+'%'
				  LEFT OUTER JOIN [dbo].[tbl_SS_Remedy_TT_CellTask] tsk
				  ON DS.Site_ID = tsk.Site_ID AND tsk.Request_Status = 0
				  WHERE TTnumber IS NULL 
						
				ORDER BY DS.Site_ID;";
				//AND SS.Site_ID IS NOT NULL
				$stmt = sqlsrv_query( $conn, $sql );
				if( $stmt === false) {
					die( print_r( sqlsrv_errors(), true) );
				}
				$found = false;
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					$found = true;
										
					$downDays = $row['downDays'];

					array_push($data_Desc,$row['Site_ID']);
					array_push($data_siteType,$row['Site_Type']);
					array_push($data_siteNode,$row['Node']);
					array_push($data_siteUrgency,$row['Urgency']);
					array_push($data_siteCells,$row['cellscount']);
					array_push($data_siteTRU,$row['TRU_Num']);
					array_push($data_modifiedDate,$row['LastModified_Date']);
					array_push($data_downDate,$row['DownTime_StartDate']);
					array_push($data_area,$row['Area']);
					array_push($data_region,$row['Region']);
					array_push($data_TT,$row['TTnumber']);
					array_push($data_SA_Time,$row['SA_Time']);
					array_push($data_Assigned_Team,$row['Assigned_Team']);
					array_push($data_Chronic_Site,$row['Chronic_Site']);
					array_push($data_Outage,$row['Outage']);
					array_push($data_HUB,$row['HUB']);
					array_push($data_Site_Grade,$row['Site_Grade']);
					array_push($data_Val,$downDays);
					array_push($data_Halt,$row['Request_Status']);
					array_push($Outage_Parent_AffecSites,$row['outage_parent_affectedSites']);
					array_push($Outage_Parent_siteID,$row['outage_parent_siteID']);
					array_push($Number_of_Cascaded,$row['Number_of_Cascaded']);
					if ($row['outage_parent_siteID'] != '') $affSites++;
				}
			sqlsrv_free_stmt( $stmt);
		$sumSites = count(array_unique($data_Desc));
		//$affSites = count($Outage_Parent_AffecSites)) -1; //Remove Blank
		// Close the connection.
		sqlsrv_close( $conn );
	
?>		
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1.0", {'packages':['controls']}); 
	google.setOnLoadCallback(draw_Records);  
	
	function draw_Records() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Site', 'Site Type','Node','Down Date','Down Days','Cells','TRUs','Number of Cascaded','Requested Status','OSS Last Update','Area','Region','Remedy TT','SA Date','Parent Site'],                    
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						$site = $data_Desc[$i];
						$open_affected = "window.open('Outage_sites.php?site=".$Outage_Parent_siteID[$i]."', 'newwindow', 'width=300, height=250'); return false;";
						echo "['".$site."','".$data_siteType[$i]."','".$data_siteNode[$i]."','".$data_downDate[$i]."',".$data_Val[$i].",".$data_siteCells[$i].",".$data_siteTRU[$i].",".$Number_of_Cascaded[$i].",'".$data_Halt[$i]."','".$data_modifiedDate[$i]."','".
								$data_area[$i]."','".$data_region[$i]."','".$data_TT[$i]."','".$data_SA_Time[$i]."','<a href=Outage_sites.php?site=".$Outage_Parent_siteID[$i]." target=_blank >".$Outage_Parent_siteID[$i]."</a>']"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  
			?>
			] ); 
			
		// Create a range slider, passing some options   
		var numFilter = new google.visualization.ControlWrapper({     
			'controlType': 'NumberRangeFilter',     
			'containerId': 'filter_div',     
			'options': {       'filterColumnLabel': 'Down Days'  , 'ui': {'format':{'fractionDigits':0} }  }   
		});
		// Create a pie chart, passing some options   
		var table = new google.visualization.ChartWrapper({     
			'chartType': 'Table',     
			'containerId': 'table_div'  ,
			'options': {   "allowHtml": true,    "showRowNumber" : true      } 
			});
		
		//drawTable
		//var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(dataTable, {showRowNumber: true});       
		
		// Create a dashboard.         
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div')); 
		
		// Establish dependencies, declaring that 'filter' drives 'pieChart',         
		// so that the pie chart will only display entries that are let through         
		// given the chosen slider range.         
		dashboard.bind(numFilter, table);          
		
		// Draw the dashboard.         
		dashboard.draw(dataTable);		
	} 
</script>   
<table >
	<tr>
		<td colspan=2><?php //echo "Sites down more than 3 days: $sum";?>  </td>
	</tr>
	<!--Div that will hold the dashboard-->   
	<div id="dashboard_div">  
	<tr >
		<!--Divs that will hold each control and chart-->       
		<td><div id="filter_div"></div>       </td>
	</tr>
	<tr>	<td><div id="table_div"></div>     </td>
	</div>
	</tr>
	<tr><td colspan=2>Number of Distinct non-TT Sites = <?php echo $sumSites;?></td></tr>
	<tr><td colspan=2>Number of Affected Sites = <?php echo $affSites;?></td></tr>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>
<?php //include ("footer_tools.php");  ?>