<?php
function getCustomerinfo($CID) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT * 
           FROM customer 
           WHERE CustomerID= ?");
    $stat->execute(array($CID));
    $row = $stat->fetch();
    $count = $stat->rowCount();



    return array(
        'email' => $row['Email'],
        'phone_Number' => $row['Phone_number'],
        'address' => $row['address'],
        'fullname' => $row['fullname']

    );

        // Close the connection
        $con->close();
}


?>

