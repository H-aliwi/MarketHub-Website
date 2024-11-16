
<?php
function get_shop_newOrdersNO($shopID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT COUNT(*) AS new_orders_count
    FROM shop_order
    WHERE shopID = ? AND IsDelivered = 'No';");
    $stat->execute(array($shopID));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $new_orders_count = $row['new_orders_count'];



    // Return the username
    return  $new_orders_count;

        // Close the connection
        $con->close();
}


?>

