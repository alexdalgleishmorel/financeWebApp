<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!session_id()) session_start();

    $username = $_POST["username"];
    $password = $_POST["password"];

    $success = TRUE;

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "SELECT * FROM Profile WHERE username='$username'";

    $result = NULL;
    $row = NULL;

    try {
        $result = mysqli_query($con, $sql);
    } catch (Exception $e) {
        echo $e;
        $success = FALSE;
    }

    if (!$success) {
        $_SESSION['response'] = 'failure';
    } else {

        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result)==0) {
            $_SESSION['response'] = "badUsername";
        } else if ($row['user_password'] != $password) {
            $_SESSION['response'] = 'badPassword';
        } else {
            $_SESSION['response'] = 'success';
        }
    }
    mysqli_close($con);
}

?>