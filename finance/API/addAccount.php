<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];
    $account_name = $_POST["account_name"];
    $account_value = $_POST["account_value"];
    $currency = $_POST["currency"];

    $success = TRUE;

    $account_value = floatval($account_value);

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "INSERT INTO Account (username, account_name, currency, value) VALUES ('$username', '$account_name', '$currency', $account_value)";

    try {
        mysqli_query($con,$sql);
    } catch (Exception $e) {
        echo $e;
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

?>