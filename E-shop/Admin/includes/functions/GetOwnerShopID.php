<?php
function GetOwnerShopID($shopId) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT *
    from shop s, Shop_Owner so 
    WHERE s.Shop_OwnerID =so.Shop_OwnerID and s.shopID =?;");
    $stat->execute(array($shopId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shop_ownerID = $row['Shop_OwnerID'];



    // Return the username
    return $shop_ownerID;

        // Close the connection
        $db->close();
}


?>

