<?php
function getCustomerIMGByUserId($userId) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT c.Account_img 
                          FROM customer c, chat_room r 
                          WHERE r.user1_id = c.CustomerID AND r.user1_id = ?");
    $stat->execute(array($userId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $Account_img = $row['Account_img'];



    // Return the username
    return $Account_img;

        // Close the connection
        $con->close();
}


?>

