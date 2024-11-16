<?php
function get_shop_itemsNO($shopID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT COUNT(*) AS item_count
    FROM item
    WHERE shopID = ?;");
    $stat->execute(array($shopID));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $item_count = $row['item_count'];



    // Return the username
    return  $item_count;

        // Close the connection
        $con->close();
}


?>

