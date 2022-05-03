<?php
// Creating a session to share connection information
if(!session_id()) session_start();

$success = TRUE;

// Create connection
try {
    $con = mysqli_connect("localhost", "", "", "");
}
catch (Exception $e) {
    $success = FALSE;
    echo $e;
}

$_SESSION['connection'] = $con;
?>