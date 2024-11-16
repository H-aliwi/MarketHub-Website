<?php
function CkeckSenderMsg($senderID,$user) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT CustomerID ,Username
                          FROM customer
                          WHERE CustomerID=? and Username=?  ");
    $stat->execute(array( $senderID,$user));
    $row = $stat->fetch();
    $count = $stat->rowCount();
    if ($count >0 ){
        return 1;
    }
    else{  return 0 ;}





        // Close the connection
        $con->close();
}


?>

