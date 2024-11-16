<?php
session_start();

// get the email for $_SESSION['usernameA']
include("connection.php"); // Database connection file

// Check if the request method is POST and the 'email' parameter is present
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email'])) {
    $email = $_POST['email'];
    include('includes/functions/getCustomerinfo.php');

    $CID = $_SESSION['UserID'];
    $CData=getCustomerinfo($CID);
    $Cemail = $CData['email'];

    // Prepare and execute a query to check if the email exists
    $stat = $con->prepare("SELECT Email FROM shop_owner WHERE Email = ? AND Email != ?");
    $stat->execute(array($email, $Cemail));
    $row = $stat->fetch();
    $count = $stat->rowCount();

    $stat_2 = $con->prepare("SELECT Email FROM customer WHERE Email = ? AND Email != ?");
    $stat_2->execute(array($email, $Cemail));
    $row = $stat_2->fetch();
    $count_2 = $stat_2->rowCount();

    // Return the response based on the result
    if ($count > 0 || $count_2 > 0) {
        echo "1"; // Email is already taken
    } else {
        echo "0"; // Email is available
    }
} else {
    // Invalid request method or missing 'email' parameter
    echo "error";
}
?>