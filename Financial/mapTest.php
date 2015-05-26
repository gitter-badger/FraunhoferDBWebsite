<html>
  <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawMarkersMap);
      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['City',  'Number of pos', 'Number of tools'],
        ['Santa Clara', 2761477, 1285.31],
        ['Jackson MI', 1324110, 181.76],
        ['Wixom MI', 959574, 117.27],
        ['Cass City', 907563, 130.17],
        ['Lenexa', 655875, 158.9],
      ]);

      var options = {
        region: 'US',
        displayMode: 'markers',
        colorAxis: {colors: ['green', 'blue']}
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