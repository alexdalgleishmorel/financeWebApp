<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!session_id()) session_start();

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $asset = $_GET['asset'];

    $sql = "SELECT * FROM Asset_price_history WHERE asset_name='$asset'";
            
    $results = mysqli_query($con,$sql);

    $rows = [];
    while($row = mysqli_fetch_array($results)){
        $rows[] = $row;
    }

    if ($rows == []) {
        $_SESSION['response'] = 'empty';
    } else {
        $dateHistory = [];
        $priceHistory = [];
        foreach ($rows as $row) {
            $dateHistory[] = $row['a_date'];
            $priceHistory[] = $row['price'];
        }
        $_SESSION['response'] = array($dateHistory, $priceHistory);
    }

    mysqli_close($con);
}

?>