<?php

if(!session_id()) session_start();

$_SERVER["REQUEST_METHOD"] = "GET";
include("API/getAccounts.php");
$_SESSION['accounts'] = $_SESSION['response'];
$_SERVER["REQUEST_METHOD"] = "GET";
include("API/getAssets.php");
$_SESSION['assets'] = $_SESSION['response'];

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
        <a href="#" class="icon solid fa-home"><span>Home</span></a>
        <a href="#Portfolio" class="icon solid fa-folder"
          ><span>Portfolio</span></a
        >
        <a href="#Add" class="icon solid fa-plus"><span>Add</span></a>
        <a href="#Metrics" class="icon solid fa-chart-line"><span>Metrics</span></a>
        <a href="index.php" class="icon solid fa-arrow-right-from-bracket"> <span>Logout</span></a>
      </nav>

      <!-- Main -->
      <div id="main">
        <!-- Me -->
        <article id="home" class="panel intro">
          <header>
            <h1>
              Welcome,
              <?php echo $_SESSION['username']; ?>
            </h1>
            <p></p>
          </header>
          <header>
            <?php
            echo "<p> Your networth is </p>";
            $accounts = $_SESSION['accounts'];
            $assets = $_SESSION['assets'];
            include("API/calcProfileNetworth.php");
            list($totalBookValue, $totalNetworth, $gainLossD, $gainLossP) = 
              calculateNetworth($accounts, $assets);
            $_SESSION['totalBookValue'] = $totalBookValue;
            echo "<h1> $&nbsp;". number_format($totalNetworth, 2) . "&nbsp;<font size='-0.5'>CAD</font></h1>";
            if ($gainLossD < 0) {
              echo "<p> <font color=red>".number_format($gainLossD, 2) . 
                "&nbsp;(" . number_format($gainLossP, 2) . "%)" ."</font>";
            }
            else {
              echo "<p> <font color=green> +".number_format($gainLossD, 2) . 
                "&nbsp;(" . number_format($gainLossP, 2) . "%)" ."</font>";
            }
            echo "<br />";
            $date = date('Y/m/d');
            echo "as of&nbsp;$date";
            echo "</p>";
            ?>
          </header>
        </article>

        <!-- Portfolio -->
        <article id="Portfolio" class="panel">
          <header>
            <h2>Your Portfolio</h2>
            <p>Select an account or asset name to make changes to its information. <br />
            Navigate to the '+' section to add new accounts or assets to your portfolio.
          </p>
          </header>
          <h3>Accounts</h3>
          <?php
          if ($_SESSION['accounts'] == 'empty') {
            echo "<p> No accounts to display. </p>";
          }
          else {
            $accounts = $_SESSION['accounts'];
            echo "<table align='left'> <tr> <th align='left'> <b>Name</b> </th>
             <th align='left'> <b>Amount</b> </th> <th align='left'> <b>Currency</b> </th> </tr>";
            foreach ($accounts as $account) {
              echo "<tr>";
              echo "<td align='left'> <a href='accountEditor.php?account=". $account['account_name']
                ."'>". $account['account_name'] ."</a> </td>";
              echo "<td align='left'>". number_format($account['value'], 2) ."</td>";
              echo "<td align='left'>". $account['currency'] ."</td>";
              echo "</tr>";
            }
            echo "</table>";
          }
          ?>
          <h3>Assets</h3>

          <?php
          if ($_SESSION['assets'] == 'empty') {
            echo "<p> No assets to display. </p>";
          }
          
          else {
            $assets = $_SESSION['assets'];
            echo "<table align='left'> <tr> <th align='left'> <b>Name</b> </th>
             <th align='left'> <b>Currency</b> </th> <th align='left'> <b>Average Cost</b> </th>
             <th align='left'> <b>Market Value</b> </th> <th align='left'> <b>Net Gain/Loss</b> </th>
             </tr>";
            foreach ($assets as $asset) {
              $colour = 'green';
              if ($asset->gainLossD < 0) {
                $colour = 'red';
              }
              echo "<tr>";
              echo "<td align='left'> <a href='assetEditor.php?asset=". $asset->name
                ."'>". $asset->name ."</a> </td>";
              echo "<td align='left'>". $asset->currency ."</td>";
              echo "<td align='left'>". number_format($asset->averageCost, 2) ."</td>";
              echo "<td align='left'>". number_format($asset->marketValue, 2) ."</td>";
              echo "<td align='left'> <font color=".$colour.">". number_format($asset->gainLossD, 2) . 
                " (" . number_format($asset->gainLossP, 2) . "%)" ."</font> </td>";
              echo "</tr>";
            }
            echo "</table>";
          }
          echo "<br />";
          ?>
        </article>

        <!-- Add -->
        <article id="Add" class="panel">
          <header>
            <h2>Add New Accounts or Assets</h2>
          </header>
          <form action="accountCreator.php" method="post">
            <div>
              <div class="row">
                <div class="col-12">
                  <input type="submit" value="Add New Account" />
                </div>
              </div>
            </div>
          </form>
          <form action="assetCreator.php" method="post">
            <div>
              <div class="row">
                <div class="col-12">
                  <input type="submit" value="Add New Asset" />
                </div>
              </div>
            </div>
          </form>
        </article>

        <!-- Metrics -->
        <article id="Metrics" class="panel">
          <header>
            <h2>Metrics</h2>
          </header>
          <form action="networthVisualizer.php" method="post">
            <div>
              <div class="row">
                <div class="col-12">
                  <input type="submit" value="View Networth History" />
                </div>
              </div>
            </div>
          </form>
          <form action="assetSelector.php" method="post">
            <div>
              <div class="row">
                <div class="col-12">
                  <input type="submit" value="Asset Visualizer" />
                </div>
              </div>
            </div>
          </form>
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
