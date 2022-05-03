<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!session_id()) session_start();

    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    if ($password1 != $password2) {
        $_SESSION['response'] = 'badPassword';
    }
    else {
        $success = TRUE;

        // Create connection
        include("accessDatabase.php");
        $con = $_SESSION['connection'];

        $sql = "SELECT * FROM Profile WHERE username='$username'";

        try {
            $result = mysqli_query($con,$sql);
        } catch (Exception $e) {
            $success = FALSE;
        }

        if (mysqli_num_rows($result) != 0) {
            $success = FALSE;
        }

        $sql = "INSERT INTO Profile (username, user_password) VALUES ('$username', '$password1')";

        try {
            mysqli_query($con,$sql);
        } catch (Exception $e) {
            $success = FALSE;
        }

        if ($success) {
            $_SESSION['response'] = 'success';
        }
        else {
            $_SESSION['response'] = 'failure';
        }

        mysqli_close($con);
    }
}

?>