<?php
// Establish database connection
include("connection.php");

// Get the selected message ID from the AJAX request
if (isset($_POST['msg_id'])) {
    $selectedMsgID = $_POST['msg_id'];

    // Prepare and execute the DELETE statement
    $stat = $con->prepare("DELETE FROM messages WHERE msg_id = ?");
    $stat->execute(array($selectedMsgID));

    // Check if the deletion was successful
    if ($stat->rowCount() > 0) {
        echo "Message has been deleted successfully.";
    } else {
        echo "No record deleted.";
    }
} else {
    echo "Invalid request.";
}
?>