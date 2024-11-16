
<?php
function GetShopNO() {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT COUNT(*) AS shops_count
    FROM shop");
    $stat->execute(array());
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shops_count = $row['shops_count'];



    // Return the username
    return  $shops_count;

        // Close the connection
        $db->close();
}


?>

