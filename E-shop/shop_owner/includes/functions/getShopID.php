<?php
function getShopID($ownerId) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT s.shopID
                          FROM shop s, shop_owner sh
                          WHERE s.Shop_OwnerID = sh.Shop_OwnerID AND sh.Shop_OwnerID = ?");
    $stat->execute(array($ownerId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shopID = $row['shopID'];



    // Return the username
    return $shopID;

        // Close the connection
        $con->close();
}


?>

