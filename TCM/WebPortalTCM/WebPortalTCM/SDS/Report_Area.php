<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  

	if (isset($_GET['area'])) {
			
		$area = str_replace("__"," ",$_GET['area']);
		$data_codedConnectivity  = array();
		$data_Desc = array();
		$data_Val = array();
		$data_siteNode = array();
		$data_siteType = array();
		$data_downDate = array();
		$data_siteCells = array();
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
		$Number_of_Cascaded = array();
			
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
	
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'], "PWD"=>$ini_array['DB_PASS'], "Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		//Down Scattered Sites WHERE SS.Region = 'Cairo'
		$sql = "SELECT DISTINCT SS.Site_ID,CC.Code,DS.Node,DS.DownTime_StartDate,SS.Site_Type,DS.LastModified_Date,SS.Area,SS.Region,Cell.Request_Status,
						dbo.Cascaded_sites(CC.Code) Number_of_Cascaded,
						DATEDIFF(day,DS.DownTime_StartDate,DS.LastModified_Date) downDays
				FROM dbo.tbl_SS_DownSites DS
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
									 				ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END )
				  LEFT OUTER JOIN dbo.vw_SS_Remedy_TT_SDS_Resolved RSV
				  ON RSV.SiteID = DS.Site_ID
				  LEFT OUTER JOIN dbo.vw_SS_Remedy_TT_CellTask Cell
				  ON DS.Site_ID = Cell.Site_ID AND Request_Status = 'Halt'
				  LEFT OUTER JOIN dbo.tbl_SS_Coded_Connectivity CC
				  ON  CC.Site_ID = DS.Site_ID
				  where SS.Site_ID IS NOT NULL
				  AND SS.Area = '$area'
				  ORDER BY 2,1 ASC;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
				$site = $row['Site_ID'];
				array_push($data_Desc,$site);
				array_push($data_siteType,$row['Site_Type']);
				array_push($data_codedConnectivity,$row['Code']);
				array_push($data_siteNode,$row['Node']);
				array_push($data_siteCells,$row['Affected_TRUs']);
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
				array_push($Number_of_Cascaded,$row['Number_of_Cascaded']);
				
				//print $data_codedConnectivity ;
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1.0", {'packages':['controls']}); 
	google.setOnLoadCallback(draw_sites);  
	
	function draw_sites() {         
		var dataTable = google.visualization.arrayToDataTable([           
						['Site','Site Type','Code','Node','# Of Affected Cells','Down Date','Number of Cascaded','Last Update','Area','Region','HUB','Remedy TT','SA Date','Assigned Team','Chronic','Outage','P'],                    
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						$site = $data_Desc[$i];
						echo "['".$site."','".$data_siteType[$i]."','".$data_codedConnectivity[$i]."','".$data_siteNode[$i]."','".$data_siteCells[$i]."','".$data_downDate[$i]."',".$Number_of_Cascaded[$i].",'".$data_modifiedDate[$i]."','".$data_area[$i]."','".$data_region[$i]."','".$data_HUB[$i]."','".$data_TT[$i]."','".$data_SA_Time[$i]."','".$data_Assigned_Team[$i]."','".$data_Chronic_Site[$i]."','".$data_Outage[$i]."','".$data_Site_Grade[$i]."']"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 

			
		//drawTable
		//var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(data, {showRowNumber: true});       
		
		// Create a range slider, passing some options   
		var categoryFilter = new google.visualization.ControlWrapper({     
			'controlType': 'CategoryFilter',     
			'containerId': 'filter_div',     
			'options': {       'filterColumnLabel': 'Site Type'     }   
		});
		// Create a pie chart, passing some options   
		var table = new google.visualization.ChartWrapper({     
			'chartType': 'Table',     
			'containerId': 'table_div'  ,
			'options': {       "showRowNumber" : true      } 
			});
			
		// Create a dashboard.         
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div')); 
		
		// Establish dependencies, declaring that 'filter' drives 'pieChart',         
		// so that the pie chart will only display entries that are let through         
		// given the chosen slider range.         
		dashboard.bind(categoryFilter, table);          
		
		// Draw the dashboard.         
		dashboard.draw(dataTable);
		       
	} 
</script>   
<table >
	<tr>
		<td colspan=2><?php echo "$region: $area";?>  </td>
	</tr>
	<!--Div that will hold the dashboard-->   
	<div id="dashboard_div">       
	<tr>
		<!--Divs that will hold each control and chart-->       
		<td><div id="filter_div"></div>       </td>
	</tr>
	<tr>	<td><div id="table_div" style="width: 2000px; height: 1000px;"></div>     </td>
	</div>
	</tr>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>
<?php			
		
	}
	else
		echo "No Area specified.";
?>					