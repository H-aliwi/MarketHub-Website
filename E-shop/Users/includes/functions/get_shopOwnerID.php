<?php
function get_shopOwnerID($shopID) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT so.Shop_OwnerID 
    FROM shop_owner so
    INNER JOIN shop s ON so.Shop_OwnerID = s.Shop_OwnerID
    WHERE s.shopID =?;");
    $stat->execute(array($shopID));
    $row = $stat->fetch();
    $count = $stat->rowCount();



    // return array(
    //     'Shop_Owner_ID' => $row['Shop_OwnerID'],
    //     'shop_Name' => $row['shop_Name'],
    
    // );

    return $Shop_Owner_ID =$row['Shop_OwnerID'];

        // Close the connection
        $con->close();
}


?>

