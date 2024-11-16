<?php
include("connection.php"); // Database connection file

// Check if the request method is GET and the 'username' parameter is present
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['shopName'])) {
    
    $shopName = $_POST['shopName'];
    // Prepare and execute a query to check if the username exists
    $stat = $con->prepare("SELECT shop_Name FROM shop WHERE shop_Name = ?");
    $stat->execute(array($shopName));
    $row = $stat->fetch();
    $count = $stat->rowCount();


    // Return the response based on the result
    if ($count > 0 ) {
        echo "1"; // Username is already taken
    } else {
        echo "0"; // Username is available
    }
} else {
    // Invalid request method or missing 'username' parameter
    echo "error";
}
?>