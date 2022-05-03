<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];
    $asset_name = $_POST["asset_name"];
    $currency = $_POST["currency"];
    $shares = $_POST["shares"];
    $ticker = $_POST["ticker"];
    $average_cost = $_POST["average_cost"];

    $_SESSION['ticker'] = $ticker;

    $success = TRUE;

    // Validating the given ticker symbol
    include("getMarketPrice.php");
    $marketPrice = $_SESSION['marketPrice'];

    // Validating the given shares value, by attempting to convert to a float
    $shares = floatval($shares);
    if ($shares == 0) {
        $_SESSION['response'] = 'badShares';
    } else {
        // Validating the given average cost value, by attempting to convert to a float
        $average_cost = floatval($average_cost);
        if ($average_cost == 0) {
            $_SESSION['response'] = 'badAverageCost';
        } else {
            if ($marketPrice == 'badTicker') {
                $_SESSION['response'] = 'badTicker';
            }
            else {
                // Create connection
                include("accessDatabase.php");
                $con = $_SESSION['connection'];
        
                $sql = "INSERT INTO Asset (asset_name, username, currency, shares, y_finance_ticker, average_cost)
                 VALUES ('$asset_name', '$username', '$currency', $shares, '$ticker', $average_cost)";

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
    }
}

?>