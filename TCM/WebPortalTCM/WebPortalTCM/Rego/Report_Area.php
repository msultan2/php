<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php	  

	if (isset($_GET['area'])) {
			
		$area = str_replace("__"," ",$_GET['area']);
		$data_Val = array();
		$data_site = array();
		$data_siteType = array();
		$data_downDate = array();
		$data_siteUrgency = array();
		$data_siteCells = array();
		$data_modifiedDate = array();
			
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
		$sql = "SELECT DS.Site_ID,DS.cellscount,DS.Urgency,DS.Node,DS.DownTime_StartDate,SS.Site_Type,DS.LastModified_Date,SS.Area,SS.Region,HUB,TTnumber,CAST(SA_Time AS VARCHAR(50)) SA_Time,TT.Assigned_Team,TT.Chronic_Site,TT.Outage,TT.Site_Grade,
						DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays
				  FROM dbo.tbl_SS_DownSites DS
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
													ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
													END )
				  LEFT OUTER JOIN dbo.tbl_SS_Remedy_TT TT
				  ON  TT.Site_ID = DS.Site_ID
				  WHERE SS.Area = '$area'
				  ORDER BY 2,1 ASC;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		//echo "qqqq: ".$sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$site = $row['Site_ID'];
			
			array_push($data_site,$site);
			$data_siteType[$site] = $row['Site_Type'];
			$data_siteUrgency[$site] = $row['Urgency'];
			$data_siteCells[$site] = $row['cellscount'];
			$data_modifiedDate[$site] = $row['LastModified_Date'];
			$data_downDate[$site] = $row['DownTime_StartDate'];
			$region = $row['Region'];
			$data_TT[$site] = $row['TTnumber'];
			$data_SA_Time[$site] = $row['SA_Time'];
			$data_Assigned_Team[$site] = $row['Assigned_Team'];
			$data_Chronic_Site[$site] = $row['Chronic_Site'];
			$data_Outage[$site] = $row['Outage'];
			$data_HUB[$site] = $row['HUB'];
			$data_Site_Grade[$site] = $row['Site_Grade'];
			array_push($data_Val,$row['downDays']);
			//echo "$site    |    $data_siteType[$site]    |    $data_downDate[$site]    |    $area     |     $region<BR>";
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
			['Site ID', 'Site Type','Down Date','Down Days','Urgency','OSS Last Modified','Area','Region','HUB','Remedy TT','SA Date','Assigned Team','Chronic','Outage','P'],           //,  { role: 'annotation' }
			<?php for($i=0;$i<count($data_site); $i++) {     
						$site = $data_site[$i];
						echo "['".$site."','".$data_siteType[$site]."','".$data_downDate[$site]."',".$data_Val[$i].",'".$data_siteUrgency[$site]."','".$data_modifiedDate[$site]."','".$area."','".$region."','".$data_HUB[$site]."','".$data_TT[$site]."','".$data_SA_Time[$site]."','".$data_Assigned_Team[$site]."','".$data_Chronic_Site[$site]."','".$data_Outage[$site]."','".$data_Site_Grade[$site]."']"; 
						if ($i<count($data_site)-1) echo ",";	//add ',' to all except last element
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
	<tr>	<td><div id="table_div"></div>     </td>
	</div>
	</tr>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>
<?php			
		
	}
	else
		echo "No Area specified.";
?>					