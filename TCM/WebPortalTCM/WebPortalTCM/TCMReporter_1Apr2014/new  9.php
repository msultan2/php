<html>
  <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['Country',   'Population', 'Area Percentage'],
        ['France',  65700000, 50],
        ['Germany', 81890000, 27],
        ['Poland',  38540000, 23],
      ]);

      var options = {
        sizeAxis: { minValue: 0, maxValue: 100 },
        region: '155', // Western Europe
        displayMode: 'markers',
        colorAxis: {colors: ['#e7711c', '#4374e0']} // orange to blue
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>