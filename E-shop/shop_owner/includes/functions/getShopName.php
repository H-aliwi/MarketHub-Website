

<?php
function getShopName($ownerID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT s.shop_Name from shop_owner so ,shop s
    WHERE so.Shop_OwnerID =s.Shop_OwnerID and so.Shop_OwnerID = ? ");
    $stat->execute(array($ownerID));
    $row = $stat->fetch();
    $count = $stat->rowCount();


    $shop_Name= $row['shop_Name'];



    // Return the username
    return $shop_Name;

        // Close the connection
        $con->close();
}


?>

