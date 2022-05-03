<?php
include('API/asset.php');

if(!session_id()) session_start();

if(isset($_GET['asset'])) {
    $_SESSION['assetToGet'] = $_GET['asset'];
}

include('API/getAsset.php');
$_SESSION['assetToEdit'] = $_SESSION['response'];

if(array_key_exists("createButton", $_POST)) {
  createAsset();
  $_SESSION['assetToEdit'] = updateAsset($_POST['asset_name']);
}
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
            <a href="home.php#Portfolio" class="icon solid fa-home"><span>Home</span></a>
      </nav>

      <!-- Main -->
      <div id="main">

        <!-- Add -->
        <article id="Add" class="panel">
          <header>
            <h2>Asset Information</h2>
            <?php
              if(!session_id()) session_start();
              if ($_SESSION['response'] == 'success') {
                echo "<br /> <h3 style='color:green'> Asset update successful. </h3>";
                echo "<p> Select the home button to return to main profile. </p>";
              }
              if ($_SESSION['response'] == 'failure') {
                echo "<br /> <h3 style='color:red'> Asset update failed, please try again. </h3>";
                echo "<p> Please navigate to the asset update interface if you already hold this asset. </p>";
              }
              if ($_SESSION['response'] == 'badTicker') {
                echo "<br /> <h3 style='color:red'> Please ensure the Yahoo Finance ticker is correct. </h3>";
              }
              if ($_SESSION['response'] == 'badShares') {
                echo "<br /> <h3 style='color:red'> Invalid 'shares' value, please try again. </h3>";
              }
              if ($_SESSION['response'] == 'badAverageCost') {
                echo "<br /> <h3 style='color:red'> Invalid 'Average Cost' value, please try again. </h3>";
              }
              ?>
          </header>
          <form method="post">
          <div>
              <div class="row">
                <div class="col-6 col-12-medium">
                  <?php
                  echo '<label for="name">Asset Name</label>
                  <input type="text" id="name" name="asset_name" value="';
                  echo $_SESSION['assetToEdit']->name;
                  echo '"/>';
                  ?>
                </div>
                <div class="col-6 col-12-medium">
                  <label for="currencies">Currency</label>
                    <select name="currency" id="currencies">
                      <option selected='selected'>
                        <?php
                        echo $_SESSION['assetToEdit']->currency;
                        ?>
                      </option>
                      <option value="CAD">CAD</option>
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="GBP">GBP</option>
                      <option value="JPY">JPY</option>
                    </select>
                </div>
                <div class="col-6 col-12-medium">
                  <label for="shares">Quantity/Shares</label>
                  <input type="text" id="shares" name="shares" value=
                  <?php
                  echo $_SESSION['assetToEdit']->shares;
                  ?>
                  />
                </div>
                <div class="col-6 col-12-medium">
                  <?php
                  echo '<label for="ticker">Y-Finance Ticker</label>
                  <input type="text" id="ticker" name="ticker" value="';
                  echo $_SESSION['assetToEdit']->ticker;
                  echo '"/>';
                  ?>
                </div>
                <div class="col-6 col-12-medium">
                  <label for="average_cost">Average Cost</label>
                  <input type="text" id="average_cost" name="average_cost" value=
                  <?php
                  echo number_format($_SESSION['assetToEdit']->averageCost, 2);
                  ?>
                  />
                </div>
                <?php
                  echo '<input type="hidden" name="oldAssetName" value="';
                  echo $_SESSION['assetToEdit']->name;
                  echo '"/>';
                ?>
                <div class="col-12">
                  <input type="submit" value="Update" name="createButton" />
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

<?php
function createAsset() {
  if(!session_id()) session_start();
  
  $_SESSION['response'] = 'empty2';

  $_SERVER["REQUEST_METHOD"] = "POST";

  include("API/updateAsset.php");
}
?>