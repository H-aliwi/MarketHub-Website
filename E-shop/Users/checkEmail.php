<?php
include("connection.php"); // Database connection file

// Check if the request method is GET and the 'username' parameter is present
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email'])) {
    
    $email = $_POST['email'];
    // Prepare and execute a query to check if the username exists
    $stat = $con->prepare("SELECT Email FROM shop_owner WHERE Email = ?");
    $stat->execute(array($email));
    $row = $stat->fetch();
    $count = $stat->rowCount();

    $stat_2 = $con->prepare("SELECT Email FROM customer WHERE Email = ?");
    $stat_2->execute(array($email));
    $row = $stat_2->fetch();
    $count_2 = $stat_2->rowCount();


    // Return the response based on the result
    if ($count > 0 || $count_2 > 0) {
        echo "1"; // Username is already taken
    } else {
        echo "0"; // Username is available
    }
} else {
    // Invalid request method or missing 'username' parameter
    echo "error";
}
?>