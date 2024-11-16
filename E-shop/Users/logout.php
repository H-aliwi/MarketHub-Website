<?php
session_start();         //start session

session_unset();         // Unset the data

session_destroy();       //destroy the session

header('location:index.php'); //Redirect to login page
exit();


?>
