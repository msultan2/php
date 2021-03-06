    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
<?php
	if (isset($_GET['type'])) //
		$tableType = $_GET['type'];
	
		$tableRegion = 'Giza';
		
		$data_area = array();
		$data_area_alias = array();
		$data_Val_DownSites = array();
		$data_Per_DownSites = array();
		$data_Val_AllSites = array();
		
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
		$sql_old = "SELECT SS.Area,COUNT(DS.Site_ID) Down,COUNT(SS.Site_ID) AllSites
				  FROM  dbo.tbl_SS_LK_SubRegions_Sites SS
				  LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				  ON  SS.Site_ID = DS.Site_ID AND SS.Area = DS.Area
				  WHERE SS.Site_Type = '$tableType'
				  GROUP BY SS.Area
				  ORDER BY 2 DESC;";
				  
		$sql	= "SELECT Map.Area_Location,Map.Area_Desc Area_Desc,SS.Region,COUNT(DS.Site_ID) Down,COUNT(SS.Site_ID) AllSites
				  FROM  dbo.tbl_SS_DownSites DS
				  LEFT OUTER JOIN dbo.tbl_SS_LK_SubRegions_Sites SS
				  ON  SS.Site_ID = (Select case WHEN DS.[Site_ID] LIKE '%[a-z]%' THEN DS.[Site_ID]
															ELSE cast(CAST(DS.[Site_ID] as int) as nvarchar(50))
															END )
				  LEFT OUTER JOIN dbo.tbl_SS_LK_Area_Map Map
				  ON  SS.Area = Map.Area_ID
				  WHERE SS.Site_Type like '%$tableType'
				  AND SS.Region IN ('Giza','Cairo')
				  GROUP BY MAp.Area_Location,Map.Area_Desc,SS.Region
				  ORDER BY 4 DESC;";
				  
		$stmt = sqlsrv_query( $conn, $sql );
		//echo "qqqq: ".$sql;
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			
			if($row['Down'] > 0){
				$area = $row['Area_Location'];
				//if ($area === "sahary alahram") $area = "Sahary AlAhram";
				//else if ($area === "1st gathering") $area = "1st Gathering";
				
				array_push($data_area,$area);
				array_push($data_area_alias,$row['Area_Desc']);
				$data_Region[$area] = $row['Region'];
				$data_Val_DownSites[$area] = $row['Down'];
				$data_Val_AllSites[$area] = $row['AllSites'];
				$data_Per_DownSites[$area] = 100 - round(( $row['Down'] / $row['AllSites'] )*100 , 0);
			}
		}
		//echo "area: ".$area." type: ".$type."3G: ".$data_3G_Per_DownSites[$area]."2G: ".$data_2G_Per_DownSites[$area];
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
		
		//$data_area = array_unique($data_area);
		$aggr_SS = count($data_area);
		//print_r($data_area);
	//}
?>
	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', { 'packages': ['table', 'map', 'corechart'] });
     google.setOnLoadCallback(drawMarkersMap);
	 //google.setOnLoadCallback(drawRegionsMap);

     function drawMarkersMap() {
		
	var data = google.visualization.arrayToDataTable([
		// [Region],[color],[size]
		['Area', 'Down Sites'],
		//['Dummy1',0],
		//['Dummy2',100,0],
		<?php	for($i=0;$i<count($data_area); $i++) {            
						$area = $data_area[$i];
						$area_desc = $area;
						if ($data_area_alias[$i] == "Hadaba") $area_desc = "El Hadaba El Wosta, Mokattam";
						if ($data_area_alias[$i] == "Mokatam") $area_desc = "Al Muqattam City, No. 9";
						if ($data_area_alias[$i] == "Imbaba") $area_desc = "Imbabah Al Munirah, Embabah";
						if ($data_area_alias[$i] == "Zayed") $area_desc = "Sheikh Zayed City";
						echo "['".$area_desc.", ".$data_Region[$area].", Egypt','".
								$data_area_alias[$i].": ".
								$data_Val_DownSites[$area]."']";
						if ($i<count($data_area)-1) echo ",";	//add ',' to all except last element
					}
			?>   
		]);
	
	var dataTable = google.visualization.arrayToDataTable([
		// [Region],[color],[size]
		['Area', 'Down Sites'],
		//['Dummy1',0],
		//['Dummy2',100,0],
		<?php	for($i=0;$i<count($data_area); $i++) {            
						$area = $data_area[$i];
						$area_desc = $area;
						
						echo "['".$data_area_alias[$i]."',".
								$data_Val_DownSites[$area]."]";
						if ($i<count($data_area)-1) echo ",";	//add ',' to all except last element
					}
			?>   
		]);
		var table =
            new google.visualization.Table(document.getElementById('table_div'));
        table.draw(dataTable, {showRowNumber: false});

		var options = { showTip: true,  
				icons: {
				  default: {
					normal: 'http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Chartreuse-icon.png',
					selected: 'http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Pink-icon.png'
		//			selected: 'http://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Chartreuse-icon.png'
				  }
				},
				useMapTypeControl: true }; //zoomLevel: 6 ,
		//var map = new google.visualization.Map(document.getElementById('map_div'));
		
		//map.draw(data, options);
		//map.setSelection([{'row': 4},{'row': 5},{'row': 10}]);
		var geoView = new google.visualization.DataView(data);
        geoView.setColumns([0, 1]);
		
		 var map = new google.visualization.Map(document.getElementById('map_div'));
        map.draw(geoView, {showTip: true});
		
		// Set a 'select' event listener for the table.
        // When the table is selected, we set the selection on the map.
        google.visualization.events.addListener(table, 'select',
            function() {
              map.setSelection(table.getSelection());
            });

        // Set a 'select' event listener for the map.
        // When the map is selected, we set the selection on the table.
        google.visualization.events.addListener(map, 'select',
            function() {
              table.setSelection(map.getSelection());
            });
    };
    </script>
      <!--div id="chart_div" style="width: 1700px; height: 1300px;"></div-->
	  <table align="center">
      <tr valign="top">
        <td style="vertical-align: middle; width: 70%;">
          <div id="map_div" style="width: 1000px; height: 600;"></div>
        </td>
        <td style="vertical-align: top; width: 30%;">
          <div id="table_div"></div>
        </td>
      </tr>
    </table>