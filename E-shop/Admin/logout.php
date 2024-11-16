<?php
session_start();         //start session

session_unset();         // Unset the data

session_destroy();       //destroy the session

header('location:../Users/index.php'); //Redirect Admin to login
exit();


?>
