
<?php
function GetOrderNO() {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT COUNT(*) AS orders_count
    FROM orders
   ");
    $stat->execute(array());
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $orders_count = $row['orders_count'];



    // Return the username
    return  $orders_count;

        // Close the connection
        $db->close();
}


?>

