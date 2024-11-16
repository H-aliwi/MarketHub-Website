<?php
function CkeckSenderMsg($senderID,$user) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $con->prepare("SELECT Shop_OwnerID ,Username
                          FROM shop_owner
                          WHERE Shop_OwnerID=? and Username=?  ");
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

