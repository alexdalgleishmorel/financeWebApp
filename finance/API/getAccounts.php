<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!session_id()) session_start();

    $username = $_SESSION['username'];

    // Create connection
    include("accessDatabase.php");
    $con = $_SESSION['connection'];

    $sql = "SELECT * FROM Account WHERE username='$username'";
            
    $results = mysqli_query($con,$sql);

    $rows = [];
    while($row = mysqli_fetch_array($results)){
        $rows[] = $row;
    }

    if ($rows == []) {
        $_SESSION['response'] = 'empty';
    } else {
        $_SESSION['response'] = $rows;
    }

    mysqli_close($con);
}

?>