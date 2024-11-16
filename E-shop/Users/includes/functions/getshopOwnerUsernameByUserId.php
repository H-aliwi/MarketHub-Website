<?php
function getshopOwnerUsernameByUserId($userId) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT DISTINCT p.shop_Name 
    FROM shop_owner s, chat_room r, shop p
    WHERE r.user2_id = s.Shop_OwnerID
    AND p.Shop_OwnerID = s.Shop_OwnerID
    AND r.user2_id = ?;");
    $stat->execute(array($userId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shop_Name = $row['shop_Name'];



    // Return the username
    return $shop_Name;

        // Close the connection
        $con->close();
}


?>

