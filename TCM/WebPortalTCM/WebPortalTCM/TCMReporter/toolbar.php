<html> 
	<head>   
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>   
	<script type="text/javascript">     
		google.load('visualization', '1', {packages: ['corechart']});     
		var visualization;      
		function draw() {
			drawVisualization();       
			drawToolbar();     
		}      
		function drawVisualization() {   
			var data = google.visualization.arrayToDataTable([           
			['Changes For', 'Number of Changes'],           
			['Network',120],
			['IT',200]
			] ); 
			//var container = document.getElementById('visualization_div');       
			//visualization = new google.visualization.PieChart(container);       
			//new google.visualization.Query('https://spreadsheets.google.com/tq?key=pCQbetd-CptHnwJEfo8tALA'). 
			var options = {           title: 'Changes For'  , is3D: true  , chartArea:{left:20,top:20,width:"90%",height:"90%"} };          
			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));         
			chart.draw(data, options); 
			
			//send(queryCallback);     
		}      
		function queryCallback(response) {       
			visualization.draw(response.getDataTable(), {is3D: true});     
		}      
		function drawToolbar() {       
			var components = [           
				{type: 'csv', datasource: 'https://spreadsheets.google.com/tq?key=pCQbetd-CptHnwJEfo8tALA'}     
			];        
			var container = document.getElementById('toolbar_div');       
			google.visualization.drawToolbar(container, components);     	
		};      google.setOnLoadCallback(draw);   
	</script> 
	</head> 
	<body>   
		<div id="chart_div" style="width: 270px; height: 200px;"></div>   
		<div id="toolbar_div"></div> 
	</body> 
</html>