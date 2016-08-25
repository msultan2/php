    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawMarkersMap);
	 //google.setOnLoadCallback(drawRegionsMap);

     function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['City',   'Population', 'Area Percentage'],
        ['Cairo',  65700000, 50],
        ['Giza', 81890000, 27],
        ['Alexandria',  38540000, 23],
      ]);
	  
	  var data_EG = google.visualization.arrayToDataTable([
	  // [Region],[color],[size]
		['City',   'Population', 'Area Percentage'],
		['Alexandria',4509000,50],
		['Aswan',1323000,50],
		['Asyut',3888000,50],
		['Damanhur',5327000,50],
		['Beni Suef',2597000,50],
		['Cairo',8762000,50],
		['Mansura',5559000,50],
		['Damietta',1240000,50],
		['Faiyum',2882000,50],
		['Tanta',4439000,50],
		['Giza',6979000,50],
		['Ismailia',1077000,50],
		['Kafr elSheikh',2940000,50],
		['Marsa Matruh',389000,50],
		['Minya',4701000,50],
		['Shibin elKom',3657000,50],
		['Kharga',208000,50],
		['Arish',395000,50],
		['Port Said',628000,50],
		['Banha',4754000,50],
		['Qena',2801000,50],
		['Hurghada',321000,50],
		['Zagazig',6010000,50],
		['Sohag',4211000,50],
		['elTor',159000,50],
		['Suez',576000,50],
		['Luxor',1064000,50],
	]);

      var options = {
		// backgroundColor: 'lightgreen',
        sizeAxis: { minValue: 0, maxValue: 100 },
        region: 'EG', 
        // displayMode: 'regions',
		displayMode: 'markers',
        colorAxis: {colors: ['green','#e7711c']}, // orange to blue
		// enableRegionInteractivity: true
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data_EG, options);
    };
    </script>
      <div id="chart_div" style="width: 900px; height: 500px;"></div>