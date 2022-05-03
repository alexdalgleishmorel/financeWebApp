<?php
    
if(!session_id()) session_start();

$success = TRUE;

// Create connection
include("accessDatabase.php");
$con = $_SESSION['connection'];

$sql = "SELECT username FROM Profile";

$result = NULL;
$row = NULL;

$results = mysqli_query($con,$sql);

$rows = [];
while($row = mysqli_fetch_array($results)){
    $rows[] = $row;
}

if ($rows == []) {
    $_SESSION['response'] = 'empty';
} else {
    foreach($rows as $profile) {
        $_SESSION['username'] = $profile['username'];
        $username = $profile['username'];

        $date = date('Y-m-d H:i:s'); 

        $_SERVER["REQUEST_METHOD"] = "GET";
        include('getAssets.php');
        $profileAssets = $_SESSION['response'];

        include('recordAssetHistory.php');
        $_SESSION['connection'] = $con;
        recordAssets($profileAssets);

        $_SERVER["REQUEST_METHOD"] = "GET";
        include('getAccounts.php');
        $profileAccounts = $_SESSION['response'];

        include('calcProfileNetworth.php');
        list($totalBookValue, $totalNetworth, $gainLossD, $gainLossP) = 
            calculateNetworth($profileAccounts, $profileAssets);
        
        $sql = "INSERT INTO Net_worth_history(username, n_date, net_worth, book_value) VALUES
        ('$username', '$date', $totalNetworth, $totalBookValue)";

        echo $sql;
        echo "<br />";
        echo "<br />"; 
        
        try {
            include("accessDatabase.php");
            $con = $_SESSION['connection'];
            mysqli_query($con,$sql);
        }
        catch (Exception $e) {
            echo $e;
            $result = NULL;
        }
    }
}

mysqli_close($con);

?>