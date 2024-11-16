<?php
session_start();
include("connection.php"); // Database connection file

// Check if the request method is POST and the 'username' parameter is present
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username'])) {
    $MyUsername = $_SESSION['usernameA'];
    $username = $_POST['username'];

    // Prepare and execute a query to check if the username exists
    $stat = $con->prepare("SELECT Username FROM shop_owner WHERE Username = ? AND Username != ?");
    $stat->execute(array($username, $MyUsername));
    $row = $stat->fetch();
    $count = $stat->rowCount();

    $stat_2 = $con->prepare("SELECT Username FROM customer WHERE Username = ? AND Username != ?");
    $stat_2->execute(array($username, $MyUsername));
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