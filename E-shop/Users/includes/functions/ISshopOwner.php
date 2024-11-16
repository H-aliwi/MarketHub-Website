<?php
function ISshopOwner($ID,$Room_id) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT s.Username 
    FROM shop_owner s, chat_room r  
    WHERE r.user2_id = s.Shop_OwnerID AND r.user2_id = ?");


    $stat->execute(array($ID,$Room_id));
    $row = $stat->fetch();
    $count = $stat->rowCount();

    if ($count > 0) {
        // If the count is greater than 0, return true
        return true;
    } else {
        // If the count is 0, return false
        return false;
    }
    // $shopUsername = $row['Username'];


        // Close the connection
        $con->close();
}


?>

