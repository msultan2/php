    <link href="css/style.css" rel="stylesheet" type="text/css" />

    
    <?php
		
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
				  
		$sql	= "SELECT Br.Latitude,Br.Longitude,DS.Site_ID,
				CASE WHEN DS.Site_ID IS NOT NULL THEN 'Down'
					 WHEN DS.Site_ID IS NULL THEN 'Up'  
				END Status,
				Br.Description FROM [SM_Change_Researching_DB].[dbo].[tbl.Bridgs] Br
				LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				ON Br.Site_ID = DS.Site_ID
				where Br.Description like '%6Oct%'
				AND DS.Site_ID IS NOT NULL;";
		$data_Lat = array();
		$data_Lon = array();
		$data_Desc = array();
		$data_Value = array();
		$data_Site_ID = array();
				

		
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Lat ,$row['Latitude']);
			array_push($data_Lon ,$row['Longitude']);
			array_push($data_Desc ,$row['Description']);
			array_push($data_Value ,$row['Status']);
			array_push($data_Site_ID ,$row['Site_ID']);

		}
		
		if (!$data_Lat)
		{
				array_push($data_Lat ,30.048607);
				array_push($data_Lon ,31.209118);
				array_push($data_Desc ,'UP');
				array_push($data_Value ,'UP');
				array_push($data_Site_ID ,'All');
			}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
		$aggr_SS = count($data_area);
	
?>
	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', { 'packages': ['table', 'map', 'corechart'] });
     google.setOnLoadCallback(drawMarkersMap);
     function drawMarkersMap() {
	
	var data = new google.visualization.DataTable();

	data.addColumn('number', 'Lat');
	data.addColumn('number', 'Lon'); 
	data.addColumn('string', 'Description');
	data.addColumn('string', 'Value'); 
	//data.addRows([,0,'UP','UP']);
 
       data.addRows([
		<?php 
			
			for($i=0;$i<count($data_Desc); $i++) {             
						echo "[".$data_Lat[$i].",".$data_Lon[$i].",'".$data_Desc[$i]."','".$data_Value[$i]."']"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					} 
		?>
       ]);
       
       	var dataTable = google.visualization.arrayToDataTable([
		['Site_ID','Description','Value'],

		<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "['".$data_Site_ID[$i]."','".$data_Desc[$i]."','".$data_Value[$i]."']"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
		?>
		]);
		var table =
            new google.visualization.Table(document.getElementById('table_div'));
        table.draw(dataTable, {showRowNumber: false});
		//var myLatlng = new google.maps.LatLng(30.06142, 31.241331);
		var options = {
				//center: center,
				showTip: true,  
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
        geoView.setColumns([0, 1, 2]);
		
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