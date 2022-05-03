<?php
if(!session_id()) session_start();

$_SERVER["REQUEST_METHOD"] = "GET";
include('API/getAssetHistory.php');
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
      .slidecontainer {
        width: 100%; /* Width of the outside container */
      }

      /* The slider itself */
      .slider {
        -webkit-appearance: none;  /* Override default CSS styles */
        appearance: none;
        width: 100%; /* Full-width */
        height: 25px; /* Specified height */
        background: #d3d3d3; /* Grey background */
        outline: none; /* Remove outline */
        opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
        -webkit-transition: .2s; /* 0.2 seconds transition on hover */
        transition: opacity .2s;
      }

      /* Mouse-over effects */
      .slider:hover {
        opacity: 1; /* Fully shown on mouse-over */
      }

      /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
      .slider::-webkit-slider-thumb {
        -webkit-appearance: none; /* Override default look */
        appearance: none;
        width: 25px; /* Set a specific slider handle width */
        height: 25px; /* Slider handle height */
        background: #0A75AD; /* Blue background */
        cursor: pointer; /* Cursor on hover */
      }

      .slider::-moz-range-thumb {
        width: 25px; /* Set a specific slider handle width */
        height: 25px; /* Slider handle height */
        background: #0A75AD; /* Blue background */
        cursor: pointer; /* Cursor on hover */
      }
    </style>

    <style>
        #curve_chart {
            width: 100%;
            height: 500px;
        }   
    </style>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'controls']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var historyData =
        <?php
        echo json_encode($_SESSION['response']);
        ?>
        ;
        var dateHistory = historyData[0];
        var priceHistory = historyData[1];
        var averageCost = parseFloat(<?php echo $_GET['averageCost'] ?>);
        var currentPrice = parseFloat(<?php echo $_GET['currentPrice'] ?>);
        var shares = parseFloat(<?php echo $_GET['shares'] ?>);

        // Creating data array
        var dataArray = new Array();
        // Adding column titles
        var titles = new Array('Date', 'Price', 'Average Cost');
        dataArray.push(titles);
        // Populating data
        for (var i=0; i<dateHistory.length; i++) {
            if (i == 0 || i == dateHistory.length-1) {
              var row = new Array(dateHistory[i], parseFloat(priceHistory[i]), averageCost);
            }
            else {
              var row = new Array(dateHistory[i], parseFloat(priceHistory[i]), null);
            }
            dataArray.push(row);
        }
        var data = google.visualization.arrayToDataTable(dataArray);

        var options = {
          curveType: 'function',
          interpolateNulls: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);

        window.addEventListener('resize', function() {
            chart.draw(data, options);
        }, false);

        var slider = document.getElementById("myRange");
        var cashOutput = document.getElementById("cashOutput");
        cashOutput.innerHTML = slider.value; // Display the default slider value

        slider.oninput = function() {
          window.dispatchEvent(new Event('updateChart'));
        }

        window.addEventListener('updateChart', function() {
          // Drawing the new average cost line
          try {
            newAverageCost = calculateAverageCost(slider.value, currentPrice, averageCost, shares);
          } catch (e) {
            document.write(e);
          }
          data = changeAverageCost(data, newAverageCost, dateHistory.length);
          var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
          chart.draw(data, options);
          cashOutput.innerHTML = slider.value;
        }, false);
      }

      function changeAverageCost(data, averageCost, size) {
        data.setCell(0,2,averageCost);
        data.setCell(size-1,2,averageCost);
        return data;
      }

      function calculateAverageCost(cash, currentPrice, actualAverageCost, actualShares) {
        var sharesToBuy = (cash/currentPrice);
        // Returning the new average cost based on 'sharesToBuy' shares being purchased
        return ((actualAverageCost*actualShares)
          +(currentPrice*sharesToBuy))/(actualShares+sharesToBuy);
      }
    </script>
  </head>
  <body class="is-preload">
    <!-- Wrapper-->
    <div id="wrapper">
      <!-- Nav -->
      <nav id="nav">
            <a href="assetSelector.php" class="icon solid fa-home"><span>Home</span></a>
      </nav>

      <!-- Main -->
      <div id="main">

        <!-- Chart -->
        <article id="Chart" class="panel">
          <header>
            <h2 style="text-align:center"><?php echo $_GET['asset']; ?></h2>
            <p style="text-align:center">Average Cost Visualization</p>
              <div id="curve_chart" class="chartContainer"></div>
              <p style="text-align:center"><b>Cash Spent</b></p>
              <div class="slidecontainer">
                <input type="range" min="0" max=<?php echo ''. $_SESSION['totalBookValue'] .'' ?> value="0" step="1" class="slider" id="myRange">
              </div>
              <div id="cashOutput" style="text-align:center"></div>
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
