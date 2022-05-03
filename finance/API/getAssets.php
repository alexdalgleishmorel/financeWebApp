<?php

include('asset.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "SELECT * FROM Asset WHERE username='$username'";
            
    $results = mysqli_query($con,$sql);

    $rows = [];
    while($row = mysqli_fetch_array($results)){
        $rows[] = $row;
    }

    if ($rows == []) {
        $_SESSION['response'] = 'empty';
    } else {
        $assetArray = [];
        foreach ($rows as $row) {
            $newAsset = new Asset();
            $newAsset->initialize($row['asset_name'], $row['y_finance_ticker'], 
                $row['currency'], $row['shares'], $row['average_cost']);
            $assetArray[] = $newAsset;
        }
        $_SESSION['response'] = $assetArray;
    }

    mysqli_close($con);
}

?>