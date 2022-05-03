<?php
include('API/asset.php');

if(!session_id()) session_start();

if(isset($_GET['account'])) {
    $_SESSION['accountToGet'] = $_GET['account'];
}

include('API/getAccount.php');
$_SESSION['accountToEdit'] = $_SESSION['response'];

if(array_key_exists("createButton", $_POST)) {
  createAccount();
  $_SESSION['accountToEdit'] = updateAccount($_POST['account_name']);
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
            <h2>Account Information</h2>
              <?php
              if(!session_id()) session_start();
              if ($_SESSION['response'] == 'success') {
                echo "<br /> <h3 style='color:green'> Account update successful. </h3>";
                echo "<p> Select the home button to return to main profile. </p>";
              }
              if ($_SESSION['response'] == 'failure') {
                echo "<br /> <h3 style='color:red'> Account update failed, please try again. </h3>";
              }
              ?>
          </header>
          <form method="post">
          <div>
              <div class="row">
                <div class="col-6 col-12-medium">
                <?php
                  echo '<label for="name">Account Name</label>
                  <input type="text" id="name" name="account_name" value="';
                  echo $_SESSION['accountToEdit']['account_name'];
                  echo '"/>';
                  ?>
                </div>
                <div class="col-6 col-12-medium">
                  <label for="currencies">Currency</label>
                    <select name="currency" id="currencies">
                      <option selected='selected'>
                        <?php
                        echo $_SESSION['accountToEdit']['currency'];
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
                  <?php
                  echo '<label for="value">Value</label>
                  <input type="text" id="value" name="account_value" value="';
                  echo $_SESSION['accountToEdit']['value'];
                  echo '"/>';
                  ?>
                </div>
                <?php
                  echo '<input type="hidden" name="oldAccountName" value="';
                  echo $_SESSION['accountToEdit']['account_name'];
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
function createAccount() {
  if(!session_id()) session_start();
  
  $_SESSION['response'] = 'empty';

  $_SERVER["REQUEST_METHOD"] = "POST";

  include("API/updateAccount.php");
}
?>
