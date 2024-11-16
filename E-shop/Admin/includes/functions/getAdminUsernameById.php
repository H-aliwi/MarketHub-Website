<?php

function getAdminUsernameById($adminID) {
    include("connection.php");

    // Prepare the SQL query
    $stat = $db->prepare("SELECT Username FROM admin WHERE adminID = ?");
    $stat->execute(array($adminID));
    $rows = $stat->fetchAll();
 
    if (count($rows) > 0) {
        // Return the first row's 'Username' value
        return $rows[0]['Username'];
    }
    
    return null;
}
 
 
?>
 