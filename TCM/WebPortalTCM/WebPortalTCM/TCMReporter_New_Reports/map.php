<html>
  <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Popularity'],
          ['Egypt', 200],
          ['United States', 300],
          ['Brazil', 400],
          ['Canada', 500],
          ['France', 600],
          ['RU', 700]
        ]);

        var options = {  magnifyingGlass:{enable: true, zoomFactor: 7.5}};

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>