<?php
function getLastMessageByRoomId($roomId) {
    include("connection.php");
    
    // Prepare and execute the SQL query to retrieve the last message
    $query = "SELECT * FROM messages WHERE chat_room_id = :roomId ORDER BY timestamp DESC LIMIT 1";
    $statement = $con->prepare($query);
    $statement->bindParam(':roomId', $roomId);
    $statement->execute();
    
    // Check if the query was successful
    if ($statement) {
        // Fetch the last message
        $lastMessage = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Close the database connection
        $con = null;
        
        return $lastMessage;
    } else {
        echo 'Error executing query: ' . $statement->errorInfo()[2];
        $con = null;
        return null;
    }
}
?>
