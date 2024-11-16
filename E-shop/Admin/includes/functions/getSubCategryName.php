<?php
function getSubCategryName($subCategryId) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT Sub_Category_name
                          FROM sub_category 
                          WHERE Sub_Category_ID = ?");
    $stat->execute(array($subCategryId));
    $row = $stat->fetch();
    $count = $stat->rowCount();


    $subCategry_name= $row['Sub_Category_name'];



    // Return the username
    return $subCategry_name;

        // Close the connection
        $db->close();
}


?>

