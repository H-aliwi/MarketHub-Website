<?php
function getCategryName($CategryId) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT c.Category_name
                          FROM category c ,shop_category sc
                          WHERE c.Category_ID = sc.Category_ID AND sc.Category_ID = ?");
    $stat->execute(array($CategryId));
    $row = $stat->fetch();
    $count = $stat->rowCount();


    $Category_name= $row['Category_name'];



    // Return the username
    return $Category_name;

        // Close the connection
        $con->close();
}


?>

