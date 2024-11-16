<?php
function get_shop_rate($shopID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT AVG(No_of_stars) AS average_rating ,COUNT(*) AS total_records
    FROM shop_rate
    WHERE shopID =?;");
    $stat->execute(array($shopID));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $shop_rate = number_format($row['average_rating'], 1);



    // Return the username
    return  $shop_rate;

        // Close the connection
        $con->close();
}


?>

