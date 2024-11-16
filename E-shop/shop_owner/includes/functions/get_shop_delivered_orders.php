
<?php
function get_shop_delivered_orders($shopID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT COUNT(*) AS orders_delivered_count
    FROM shop_order
    WHERE shopID = ? AND IsDelivered = 'Yes';");
    $stat->execute(array($shopID));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $orders_delivered_count = $row['orders_delivered_count'];



    // Return the username
    return  $orders_delivered_count;

        // Close the connection
        $con->close();
}


?>

