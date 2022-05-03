<?php
if(!session_id()) session_start();

$_SERVER["REQUEST_METHOD"] = "GET";
include('API/getNetworthData.php');
?>

<!DOCTYPE html>
<!--
	Astral by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <title>Finance</title>
    <script
      src="https://kit.fontawesome.com/90655985ce.js"
      crossorigin="anonymous"
    ></script>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, user-scalable=no"
    />
    <link rel="icon" href="finance.ico" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript
      ><link rel="stylesheet" href="assets/css/noscript.css"
    /></noscript>

    <style>
        #curve_chart {
            width: 100%;
            height: 500px;
        }   
    </style>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var networthData =
        <?php
        echo json_encode($_SESSION['response']);
        ?>
        ;
        // Creating data array
        var dataArray = new Array();
        // Adding column titles
        var titles = new Array('Date', 'Book Value', 'Market Value');
        dataArray.push(titles);
        // Populating data
        for (var i=0; i<networthData.length; i++) {
            var row = new Array(networthData[i][0], parseFloat(networthData[i][1]), parseFloat(networthData[i][2]));
            dataArray.push(row);
        }

        var data = google.visualization.arrayToDataTable(dataArray);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);

        window.addEventListener('resize', function() {
            chart.draw(data, options);
        }, false);
      }
    </script>
  </head>
  <body class="is-preload">
    <!-- Wrapper-->
    <div id="wrapper">
      <!-- Nav -->
      <nav id="nav">
            <a href="home.php#Metrics" class="icon solid fa-home"><span>Home</span></a>
      </nav>

      <!-- Main -->
      <div id="main">

        <!-- Chart -->
        <article id="Chart" class="panel">
          <header>
            <h2 style="text-align:center">Networth Visualization</h2>
              <div id="curve_chart" class="chartContainer"></div>
          </header>
        </article>
      </div>

      <!-- Footer -->
      <div id="footer">
        <ul class="copyright">
          <li>Finance by Alex Dalgleish-Morel</li>
          <li>Website Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul>
      </div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
