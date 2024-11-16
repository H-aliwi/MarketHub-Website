<?php
include("connection.php");

// Get the customerID and shopID from the AJAX request
$customerID = $_POST['customerID'];
$shopID = $_POST['shopID'];

// Perform the database query to check if the customer has already rated the shop
$query = "SELECT * FROM shop_rate WHERE CustomerID = :customerID AND shopID = :shopID";
$stmt = $con->prepare($query);
$stmt->bindParam(':customerID', $customerID);
$stmt->bindParam(':shopID', $shopID);
$stmt->execute();

// Check if there is a matching record in the database
if ($stmt->rowCount() > 0) {
    // Customer has already rated the shop
    echo 'rated';
} else {
    // Customer has not rated the shop
    echo 'not_rated';
}
?>