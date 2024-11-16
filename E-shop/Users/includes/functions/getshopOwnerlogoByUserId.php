<?php
function getshopOwnerlogoByUserId($userId) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT s.shop_Logo from  shop s ,Shop_Owner so 
    WHERE s.Shop_OwnerID =so.Shop_OwnerID AND so.Shop_OwnerID =?;");
    $stat->execute(array($userId));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shop_Logo = $row['shop_Logo'];



    // Return the username
    return $shop_Logo;

        // Close the connection
        $con->close();
}


?>

