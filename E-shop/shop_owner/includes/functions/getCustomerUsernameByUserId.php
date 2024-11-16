<?php
function getCustomerUsernameByUserId($userId) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT c.Username 
                          FROM customer c, chat_room r 
                          WHERE r.user1_id = c.CustomerID AND r.user1_id = ?");
    $stat->execute(array($userId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $username = $row['Username'];



    // Return the username
    return $username;

        // Close the connection
        $con->close();
}


?>

