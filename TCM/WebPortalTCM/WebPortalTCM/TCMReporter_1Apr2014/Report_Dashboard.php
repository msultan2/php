<?php include ("newtemplate.php"); ?>
<link href="style_new.css" rel="stylesheet" type="text/css" />
<?php // content="text/plain; charset=utf-8"
?>
	<!--Load the AJAX API-->     
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>     
	<script type="text/javascript">        
	
	// Load the Visualization API and the controls package.       
	google.load("visualization", "1",  {'packages':['controls']});        
	// Set a callback to run when the Google Visualization API is loaded.       
	google.setOnLoadCallback(drawDashboard);        
	
	// Callback that creates and populates a data table,       
	
	// instantiates a dashboard, a range slider and a pie chart,       
	// passes in the data and draws it.       
	
	function drawDashboard() {          
		// Create our data table.         
		var data = google.visualization.arrayToDataTable([       //    ['Requester', 'Number of Change Requests'],           ['Michael' , 5],           ['Elisa', 7],           ['Robert', 3],           ['John', 2],           ['Jessica', 6],           ['Aaron', 1],           ['Margareth', 8]         ]);          
		['Requester',  'Number of Change Requests'],           
			['Mohamed Aly-Ghareib',166],['Sahar Shaker',161],['Ahmed AlyEDeen',145],['Malak Haggag',115],['Omar youssry',109],['Aya Mostafa-Ahmed',103],['Yasmeen Talaat-Ali',102],['Mostafa AbdAllah-Darwish',100],['Ahmed Abdeen',93],['Ahmed Ali-ElSerafi',87]		] ); 
	
		// Create a dashboard.         
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div'));          
		// Create a range slider, passing some options         
		var donutRangeSlider = new google.visualization.ControlWrapper({    'controlType': 'NumberRangeFilter',           
																			'containerId': 'filter_div',           
																			'options': {             'filterColumnLabel': 'Number of Change Requests'           }         });          
		// Create a pie chart, passing some options         
		var pieChart = new google.visualization.ChartWrapper({           'chartType': 'PieChart',           'containerId': 'chart_div',           'options': {             'width': 700,             'height': 400,             'pieSliceText': 'value',             'legend': 'right'           }         });          
		// Establish dependencies, declaring that 'filter' drives 'pieChart',         
		// so that the pie chart will only display entries that are let through         
		// given the chosen slider range.         
		dashboard.bind(donutRangeSlider, pieChart);          
		// Draw the dashboard.         
		dashboard.draw(data);       
	}     
	</script>   
	</head>    
	<body>     
		<!--Div that will hold the dashboard-->     
		<div id="dashboard_div">       
			<!--Divs that will hold each control and chart-->       
			<div id="filter_div"></div>       
			<div id="chart_div"></div>     
		</div>   
<?php sqlsrv_close( $conn ); ?>
<?php include ("footer_new.php"); ?>