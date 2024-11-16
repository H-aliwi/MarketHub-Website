<?php
function getShopName($shopID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT shop_Name from shop
    WHERE shopID = ? ");
    $stat->execute(array($shopID));
    $row = $stat->fetch();
    $count = $stat->rowCount();


    $shop_Name= $row['shop_Name'];



    // Return the username
    return $shop_Name;

        // Close the connection
        $db->close();
}


?>