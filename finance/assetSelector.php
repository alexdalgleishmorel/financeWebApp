<?php
include('API/asset.php');

if(!session_id()) session_start();
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

        <!-- Add -->
        <article id="Add" class="panel">
          <h1>Select an asset to visualize</h1>
          <br />
          <p>
          <?php
          if ($_SESSION['assets'] == 'empty') {
            echo "No assets to display.";
          }
          else {
            $assets = $_SESSION['assets'];
            foreach ($assets as $asset) {
              echo "<a href='assetVisualizer.php?asset=". $asset->ticker
                ."&averageCost=". $asset->averageCost ."&currentPrice=". $asset->currentPrice
                ."&shares=". $asset->shares ."'>". $asset->name ."</a>";
              echo "<br />";
            }
          }
          ?>
          </p>
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

<?php
function createAccount() {
  if(!session_id()) session_start();
  
  $_SESSION['response'] = 'empty';

  $_SERVER["REQUEST_METHOD"] = "POST";

  include("API/updateAccount.php");
}
?>
