<?php
session_start();
// this page is for redirect users to chat room we have two cases:
// case 1 : If a room already exists, redirect to the existing room.
// case 2 : If a room doesn't exist, create a new room and redirect to it.

include("connection.php");
include('includes/functions/get_shopOwnerID.php');

// Retrieve shopID from the query parameters
$shopID = $_GET['shopID'];

// Check if the user has a room with the shop owner (receiver)
$customerID = $_SESSION['UserID']; 

$Shop_Owner_ID = get_shopOwnerID($shopID); // cell function to get  Shop_Owner_ID.
$shopOwnerID = $Shop_Owner_ID; // Replace with the actual shop owner ID

$sql = "SELECT chat_room_id FROM chat_room WHERE (user1_id = $customerID AND user2_id = $shopOwnerID) OR (user1_id = $shopOwnerID AND user2_id = $customerID)";
$result = $con->query($sql);

if ($result->rowCount() > 0) {
    // If a room already exists, redirect to the existing room
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $roomID = $row['chat_room_id'];
    header("Location: chat.php?receiver_ID=$shopOwnerID&room_id=$roomID");
    exit();
} else {
    // If a room doesn't exist, create a new room and redirect to it
    $startDate = date('Y-m-d H:i:s');

    $sql = "INSERT INTO chat_room (user1_id, user2_id, start_date) VALUES ($customerID, $shopOwnerID, '$startDate')";
    if ($con->query($sql)) {
        $roomID = $con->lastInsertId();
        header("Location: chat.php?receiver_ID=$shopOwnerID&room_id=$roomID");
        exit();
    } else {
        echo "Error creating chat room: " . $con->errorInfo()[2];
    }
}

?>