<?php
function GetItemsNO() {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT COUNT(*) AS item_count
    FROM item;");
    $stat->execute(array());
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $item_count = $row['item_count'];



    // Return the username
    return  $item_count;

        // Close the connection
        $db->close();
}


?>

