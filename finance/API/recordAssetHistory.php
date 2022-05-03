<?php

function recordAssets ($assets) {

    if(!session_id()) session_start();

    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $date = date('Y-m-d');

    foreach ($assets as $asset) {
        $name = $asset->ticker;
        $price = $asset->currentPrice;
        $sql = "INSERT INTO Asset_price_history(asset_name, a_date, price) VALUES
        ('$name', '$date', $price)";

        echo $sql;
        echo "<br />";
        echo "<br />";
        
        try {
            mysqli_query($con,$sql);
        }
        catch (Exception $e) {
            echo $e;
            $result = NULL;
        }
    }
}

?>