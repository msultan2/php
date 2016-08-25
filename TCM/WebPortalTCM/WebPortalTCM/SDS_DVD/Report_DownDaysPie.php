<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
	if (isset($_GET['type'])) 
		$tableType = $_GET['type'];
		
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
		$sql = "SELECT SS.site_id,
						DATEDIFF(day,CONVERT(datetime,DS.DownTime_StartDate,103),CONVERT(datetime,DS.LastModified_Date,103)) downDays
				FROM [SM_Change_Researching_DB].[dbo].[tbl_SS_DownSites] DS , dbo.tbl_SS_LK_SubRegions_Sites SS
				WHERE  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
												ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
												END ) 
				ORDER BY 2 DESC;";
				  
		//echo $sql;
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$sum = 0;
		if(isset($_GET['days'])) $days = $_GET['days'];
		else $days = 3;
		$data_Desc = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$downDays = $row['downDays'];
			if ($downDays >= $days) {
				array_push($data_Desc,$row['site_id']);
				array_push($data_Val,$downDays);
				$sum ++;
			}
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
<script type="text/javascript">       
	google.load("visualization", "1.0", {'packages':['controls']}); 
	google.setOnLoadCallback(draw_ChangeTypes);  
	
	function draw_ChangeTypes() {         
		var dataTable = google.visualization.arrayToDataTable([           
			['Site', '<?php echo $sum;?> Sites Down more than <?php echo $days;?> Days'],           
			<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Desc[$i]."',".$data_Val[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
			?>
			] ); 
			
		//drawTable
		//var table = new google.visualization.Table(document.getElementById('table_div'));         
		//table.draw(data, {showRowNumber: true});       
		
		//drawPieChart
		//var options = {           title: '<?php echo $sum; ?> Sites down for more than 3 days'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
		//var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
		//chart.draw(data, options); 

		// Create a range slider, passing some options   
		var numFilter = new google.visualization.ControlWrapper({     
			'controlType': 'NumberRangeFilter',     
			'containerId': 'filter_div',     
			'options': {       'filterColumnLabel': '<?php echo $sum;?> Sites Down more than <?php echo $days;?> Days'  , 'ui': {'format':{'fractionDigits':0} }  }   
		});
		// Create a pie chart, passing some options   
		var table = new google.visualization.ChartWrapper({     
			'chartType': 'Table',     
			'containerId': 'table_div'  ,
			'options': {       "showRowNumber" : true      } 
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
	<!--Div that will hold the dashboard-->   
	<div id="dashboard_div">   <a class=area_link href='Report_DownDays.php?days=3' target='_blank'>Check All Sites..</a>
	<tr >
		<!--Divs that will hold each control and chart-->       
		<td><div id="filter_div"></div>       </td>
	</tr>
	<tr>	<td><div id="table_div"></div>     </td>
	</div>
	</tr>
	<!--tr><td ><div id="table_div" ></div></td></tr-->
</table>