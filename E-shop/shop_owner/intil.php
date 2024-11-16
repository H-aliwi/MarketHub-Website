<?php  
include("connection.php");
$tmpl  = 'includes/templetes/';  // templetes deroctary
$func  = 'includes/functions/';  // functions deroctary

?>
<?php   include($func .'functionTitle.php')  ?><!--  function to get page Title-->
<?php   include($func .'getCustomerUsernameByUserId.php') ?><!--  function-->
<?php   include('includes/langauges/Eng.php')  ?><!--  eng -not doen for now -->
<?php   include($tmpl .'header.php')  ?><!--  header-->


<?php 

    if (!isset($NoNavbar)){

        include($tmpl .'navbar.php');
    
    }








?><!--  Navbar-->


