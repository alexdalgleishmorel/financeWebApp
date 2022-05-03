<?php
if(!session_id()) session_start();

$username = $_SESSION['username'];
$accountToGet = $_SESSION['accountToGet'];

// Create connection
include("accessDatabase.php");
$con = $_SESSION['connection'];

$sql = "SELECT * FROM Account WHERE username='$username' AND account_name='$accountToGet'";
        
$results = mysqli_query($con,$sql);

$row = mysqli_fetch_array($results);

if ($row == NULL) {
    $_SESSION['response'] = 'empty';
} else {
    $_SESSION['response'] = $row;
}

mysqli_close($con);

function updateAccount ($accountName) {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "SELECT * FROM Account WHERE username='$username' AND account_name='" . 
        $accountName . "'";
            
    $results = mysqli_query($con,$sql);

    $row = mysqli_fetch_array($results);

    if ($row == NULL) {
        $_SESSION['response'] = 'no account found';
    } else {
        $newAccount = $row;
    }

    mysqli_close($con);

    return $newAccount;
}

?>