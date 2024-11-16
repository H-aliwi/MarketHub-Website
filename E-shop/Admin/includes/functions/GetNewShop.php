
<?php
function GetNewShop() {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT COUNT(*) AS newShops_count
    FROM shop_owner
    where Shop_owner_state='Verifying'; ");
    $stat->execute(array());
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shops_count = $row['newShops_count'];



    // Return the username
    return  $shops_count;

        // Close the connection
        $db->close();
}


?>

