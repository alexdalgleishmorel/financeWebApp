<?php
if(!session_id()) session_start();

$success = TRUE;

$ticker = $_SESSION['ticker'];

$url = "https://query1.finance.yahoo.com/v8/finance/chart/$ticker?region=US&lang=en-US&includePrePost=false&interval=1h&useYfid=true&range=1d";

error_reporting(E_ALL ^ E_WARNING); 
$stock_data = json_decode(file_get_contents($url), true);

if ($stock_data != NULL) {
    $current = $stock_data['chart']['result'][0]['meta']['regularMarketPrice'];
    $_SESSION['marketPrice'] = $current;
} else {
    $_SESSION['marketPrice'] = 'badTicker';
}

?>