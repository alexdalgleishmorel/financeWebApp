<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];
    $account_name = $_POST["account_name"];
    $oldAccountName = $_POST["oldAccountName"];
    $account_value = $_POST["account_value"];
    $currency = $_POST["currency"];

    $success = TRUE;

    $account_value = floatval($account_value);

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "UPDATE Account SET
    username = '$username',
    account_name = '$account_name',
    currency = '$currency',
    value = $account_value 
    WHERE username='$username'
    AND account_name='$oldAccountName'";

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