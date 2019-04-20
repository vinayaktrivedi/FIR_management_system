<?php


session_start();
$db = new SQLite3('fir.db');
$qstr1 = "select count(F_id), city_name from area as a, city as c, fir_details as f where a.city_id = c.city_id and a.area_id = f.area_id group by city_name order by count(F_id) desc";
$qstr2 = "";

$result = $db->query($qstr1);

$crimehsp0 = $result->fetchArray();
$crimehsp1 = $result->fetchArray();
$crimehsp2 = $result->fetchArray();
$crimehsp3 = $result->fetchArray();
$crimehsp4 = $result->fetchArray();

    
#showing form for registering FIR
if($_POST["stage"]=="show_stats"){
    $return =<<<HTML
  <!DOCTYPE html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['City', 'Number of cases'],
          ['$crimehsp0[1]', $crimehsp0[0]],
          ['$crimehsp1[1]', $crimehsp1[0]],
          ['$crimehsp2[1]', $crimehsp2[0]],
          ['$crimehsp3[1]', $crimehsp3[0]],          
          ['$crimehsp4[1]', $crimehsp4[0]]
        ]);

        var options = {
          title: 'Top 5 crime hotspots',
          width: 900,
          // legend: { position: 'none' },
          chart: { title: 'Top 5 crime hotspots',
                   subtitle: 'by number of criminal activities to date' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Number of incidents'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
  </head>
  <body>
    <div id="top_x_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
    
HTML;
	echo $return;
}
?> 
