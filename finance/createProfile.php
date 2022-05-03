<?php
if(!session_id()) session_start();

if(array_key_exists("createButton", $_POST)) {
  createProfile();
} else {
  $_SESSION['response'] = 'empty';
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

    <nav id="nav">
            <a href="index.php" class="icon solid fa-home"><span>Home</span></a>
    </nav>

      <!-- Main -->
      <div id="main">

        <!-- Add -->
        <article id="Add" class="panel">
          <header>
            <h2>Profile Creation</h2>
              <p>Select the home icon to navigate back to the main menu.</p>
              <?php
              if(!session_id()) session_start();
              if ($_SESSION['response'] == 'success') {
                echo "<h3 style='color:green'> Profile created successfully. </h3>";
              }
              if ($_SESSION['response'] == 'failure') {
                echo "<h3 style='color:red'> This username already exists, please try again. </h3>";
              }
              if ($_SESSION['response'] == 'badPassword') {
                echo "<h3 style='color:red'> The given passwords did not match. </h3>";
              }
              ?>
          </header>
          <form method="post" autocomplete="off">
          <div>
              <div class="row">
                <div class="col-12">
                  <label for="username">Enter your username</label>
                  <input type="text" id="username" name="username" placeholder="Username" />
                </div>
                <div class="col-6 col-12-medium">
                  <label for="password1">Enter your password</label>
                  <input type="password" id="password1" name="password1" placeholder="Password" />
                </div>
                <div class="col-6 col-12-medium">
                  <label for="password2">Re-enter your password</label>
                  <input type="password" id="password2" name="password2" placeholder="Password" />
                </div>
                <div class="col-12">
                  <input type="submit" value="Create Profile" name="createButton" />
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
function createProfile() {
  if(!session_id()) session_start();
  
  $_SESSION['response'] = 'empty';

  $_SERVER["REQUEST_METHOD"] = "POST";

  include("API/addProfile.php");
}
?>
