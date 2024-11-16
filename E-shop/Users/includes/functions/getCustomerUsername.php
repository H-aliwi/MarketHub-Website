<?php
function getCustomerUsername($Cname) {
    include("connection.php");
    // Prepare the SQL query
    $stat = $con->prepare("SELECT Username 
           FROM customer 
           WHERE Username= ?");
    $stat->execute(array($Cname));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    $Cusername = $row['Username'];



    // Return the username
    return $Cusername;

        // Close the connection
        $con->close();
}


?>

