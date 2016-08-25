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
		['City',   'Population', 'Availability%'],
		['Alexandria',4509000,0],
		['Aswan',1323000,0],
		['Asyut',3888000,50],
		['Damanhur',5327000,70],
		['Beni Suef',2597000,50],
		['Cairo',8762000,50],
		['Mansura',5559000,50],
		['Damietta',1240000,50],
		['Faiyum',2882000,100],
		['Tanta',4439000,50],
		['Giza',6979000,50],
		['Ismailia',1077000,50],
		['Kafr elSheikh',2940000,100],
		['Marsa Matruh',389000,50],
		['Minya',4701000,50],
		['Shibin elKom',3657000,50],
		['Kharga',208000,50],
		['Arish',395000,50],
		['Port Said',628000,50],
		['Banha',4754000,50],
		['Qena',2801000,50],
		['Hurghada',321000,50],
		['Zagazig',6010000,30],
		['Sohag',4211000,50],
		['elTor',159000,50],
		['Suez',576000,50],
		['Luxor',1064000,50],
	]);
		var data_EG2 = google.visualization.arrayToDataTable([
		 // [Region],[color],[size]
		['City',   'Availability%', 'Population'],
		['Alexandria',10,4123869],
		['Aswan',20,1186482],
		['Asyut',10,3444967],
		['Damanhur',40,4747283],
		['Beni Suef',10,2291618],
		['Cairo',60,8471859],
		['Mansura',10,4989997],
		['Damietta',80,1097339],
		['Faiyum',10,2511027],
		['Tanta',100,4011320],
		['Giza',10,5724545],
		['Ismailia',20,953006],
		['Kafr el-Sheikh',20,2620208],
		['Marsa Matruh',30,323381],
		['Minya',40,4166299],
		['Shibin el-Kom',50,3270431],
		['Kharga',60,187263],
		['Arish',70,343681],
		['Port Said',80,570603],
		['Banha',9,4251672],
		['Qena',100,3001681],
		['Hurghada',20,288661],
		['Zagazig',30,5354041],
		['Sohag',40,3747289],
		['Suez',60,512135],
		['Luxor',70,457286],
		['Maadi',100,45728],
		['Dahab',100,45728],
		['El-Tor',80,45728],
		['Nuweiba',70,4500],
		['Saint Catherine',60,5000],
		['Sharm el-Sheikh',50,30000],
		['Zamalek',50,30000],

			]);
		var data_EG3 = google.visualization.arrayToDataTable([
		 // [Region],[color],[size]
		['City',   'Availability%', 'Population'],
		['Maadi',100,45728],
		//['Dahab',100,45728],
		//['El-Tor',80,45728],
		//['Nuweiba',70,4500],
		//['Saint Catherine',60,5000],
		//['Sharm el-Sheikh',50,30000],
		['Zamalek',50,30000],
		['Manyal',100,30000],
		['10th of Ramadan City',0,200],
		['6th of October City',0,300],
		['Imbaba',0,300],
		['Mohandesen',0,300],
		['Nasr City',0,300],
		['Boulak',0,300],
		['Mokattam',0,300],
		['Mohandessin',0,5000],
		['Agouza',0,5000],
		['Dokki',0,5000],
			]);
		
		var data_EG4 = google.visualization.arrayToDataTable([
		 // [Region],[color],[size]
		['City',  'Description', 'Availability%', 'Population'],
		['Dummy1','Dummy1',0,0],
		//['Dummy2',100,0],
		['Banha','Banha',91,4251672],
		['Qalyubia','Qalyubia',91,4251672],
		['Tanta','Tanta',89,4011320],
		['Mahalla','Mahalla',95,4011320],
		['Gharbia','Gharbia Rural',90,427680],
		['Mansoura','Mansoura',100,4989997],
		['Dakahlia','Dakahleyya Rural',92,569003],
		['Zagazig','Zagazig',100,5354041],
		['Al Sharqia','Sharkeyya Rural',93,655959],
		['Shibin el-Kom','Shibin',92,3270431],
		['Monufia','Monufeyya',89,386569],
		['Damanhur','Damanhour',97,4747283],
		['Beheira','Beheira Rural',91,579717],
		['Kafr el-Sheikh','Kafr El-Shikh',100,2620208],
		['Baltim','Kafr El-Shikh Rural',86,2792620],
		//['Al Hamool','Kafr El-Shikh Rural2',86,456],
		['Damietta','Damyata',85,953430],
		['Ras El Bar','Damyata Rural',82,286570],


		]);
		
      var options = {
		// backgroundColor: 'lightgreen',
        sizeAxis: { minValue: 0, maxValue: 100 },
        region: 'EG', 
        // displayMode: 'regions',
		displayMode: 'markers',
        //colorAxis: {colors: ['red','red','orange','orange','yellow','yellow','green']}, //'#e7711c']}, // orange to blue
		colorAxis: {colors: ['black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'black',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'red',	'orange',	'orange',	'orange',	'orange',	'orange',	'yellow',	'yellow',	'yellow',	'yellow',	'green',	'green']},

		// enableRegionInteractivity: true
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data_EG4, options);
    };
    </script>
      <div id="chart_div" style="width: 1700px; height: 1300px;"></div>