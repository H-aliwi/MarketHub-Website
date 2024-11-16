<?php
include("connection.php");

if(isset($_GET['roomid'])) {
    $roomId = $_GET['roomid'];

    // Prepare and execute the DELETE query
    $deleteQuery = "DELETE FROM chat_room WHERE chat_room_id = :roomId";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bindParam(':roomId', $roomId);
    $stmt->execute();
    $count = $stmt->rowCount();    // Check if the deletion was successful
    if($count  >0 ) {
        $_SESSION['show_message_delete_room'] = true;
        header("Location:rooms.php");
    } else {
        echo "Failed to delete room.";
    }

    $stmt->close();
}
?>