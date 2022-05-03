<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "SELECT * FROM Asset WHERE username='$username' AND asset_name='" . 
        $_SESSION['assetToGet'] . "'";
            
    $results = mysqli_query($con,$sql);

    $row = mysqli_fetch_array($results);

    if ($row == NULL) {
        $_SESSION['response'] = 'no asset found';
    } else {
        $newAsset = new Asset();
        $newAsset->initialize($row['asset_name'], $row['y_finance_ticker'], 
            $row['currency'], $row['shares'], $row['average_cost']);
        $_SESSION['response'] = $newAsset;
    }

    mysqli_close($con);
}

function updateAsset ($assetName) {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "SELECT * FROM Asset WHERE username='$username' AND asset_name='" . 
        $assetName . "'";
            
    $results = mysqli_query($con,$sql);

    $row = mysqli_fetch_array($results);

    if ($row == NULL) {
        $_SESSION['response'] = 'no asset found';
    } else {
        $newAsset = new Asset();
        $newAsset->initialize($row['asset_name'], $row['y_finance_ticker'], 
            $row['currency'], $row['shares'], $row['average_cost']);
        $newAsset;
    }

    mysqli_close($con);

    return $newAsset;
}

?>