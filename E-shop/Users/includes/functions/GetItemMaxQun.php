<?php
function GetItemMaxQun($itemID) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT Quantity 
           FROM item 
           WHERE ItemID= ?");
    $stat->execute(array($itemID));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $itemMAXQ = $row['Quantity'];



    // Return the username
    return $itemMAXQ;

        // Close the connection
        $con->close();
}


?>

