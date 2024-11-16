<?php
function getShopDataByShopID($shopId) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT shop_Name, shop_Logo
           FROM shop
           WHERE shopID = ?");
    $stat->execute(array($shopId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shopName = $row['shop_Name'];
    $shopImg = $row['shop_Logo'];

    // Close the connection
    $con = null;

    // Return the shop data as an associative array
    return array(
        'shop_Name' => $shopName,
        'shop_Logo' => $shopImg
    );
}


?>

