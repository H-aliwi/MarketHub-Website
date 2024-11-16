<?php
// Establish database connection
include("connection.php");

// Get the message from the request
$message = $_POST['message'];

// Get the sender_id and receiver_id values
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$room_ID =$_POST['room_ID'];
// Insert the message into the database
$result = $con->prepare("INSERT INTO messages (chat_room_id, sender_id, receiver_id, message_text, timestamp) VALUES (?, ?, ?, ?, NOW())");
// Execute the query with appropriate values
$result->execute(array($room_ID,$sender_id, $receiver_id, $message));



if ($result) {
    echo 'success';
} else {
    echo 'error';
}

?>