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
		//Down Scattered Sites WHERE SS.Region = 'Cairo'
				  
		$sql	= "SELECT Br.Latitude,Br.Longitude,
				CASE WHEN DS.Site_ID IS NOT NULL THEN '0'
					 WHEN DS.Site_ID IS NULL THEN '100'  
				END Value,
				Br.Description FROM [SM_Change_Researching_DB].[dbo].[tbl.Bridgs] Br
				LEFT OUTER JOIN dbo.tbl_SS_DownSites DS
				ON Br.Site_ID = DS.Site_ID
				where Br.Description like '%6Oct%'";
		$data_Lat = array();
		$data_Lon = array();
		$data_Desc = array();
		$data_Value = array();
		
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			array_push($data_Lat ,$row['Latitude']);
			array_push($data_Lon ,$row['Longitude']);
			array_push($data_Desc ,$row['Description']);
			array_push($data_Value ,$row['Value']);

		}
		//echo "area: ".$area." type: ".$type."3G: ".$data_3G_Per_DownSites[$area]."2G: ".$data_2G_Per_DownSites[$area];
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn ); 
		
		//$data_area = array_unique($data_area);
		$aggr_SS = count($data_area);
		//print_r($data_area);
?>
	<script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', { 'packages': ['table', 'map', 'corechart'] });
     google.setOnLoadCallback(drawVisualization);
	 //google.setOnLoadCallback(drawRegionsMap);

     function drawVisualization() {
var data = new google.visualization.DataTable();

       data.addColumn('number',  'LATITUDE', 'Latitude');
       data.addColumn('number', 'LONGITUDE', 'Longitude');
       data.addColumn('string', 'DESCRIPTION','Description');
       data.addColumn('number', 'VALUE','Value');
       data.addRows([
		<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo "[".$data_Lat[$i].",".$data_Lon[$i].",'".$data_Desc[$i]."',".$data_Value[$i]."]"; 
						if ($i<count($data_Desc)-1) echo ",";	//add ',' to all except last element
					}  //&cht=p3
	?>
		
       ]);
	
       var options = {
               region: 'EG',
	       sizeAxis: { minValue: 0, maxValue: 100 },
               height: '694',
               width: '1112',
	       colorAxis: {colors: ['red','red','green','green']},
               resolution: 'provinces',
               displayMode: 'markers',
       };
       

       var chart = new
google.visualization.GeoChart(document.getElementById('visualization'));
       chart.draw(data, options);
};
    </script>
      <div id="visualization" style="width: 800px; height: 500px;"></div>					
<?php //include ("Rego_Table_file.php"); ?>