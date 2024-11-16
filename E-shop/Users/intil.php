<?php  
include("connection.php");
$tmpl  = 'includes/templetes/';  // templetes deroctary
$func  = 'includes/functions/';  // functions deroctary

?>
<?php   include($func .'functionTitle.php')  ?><!--  function-->
<?php   include($func .'getshopOwnerUsernameByUserId.php')  ?><!--  function-->
<?php   include($func .'getCustomerUsername.php')  ?><!--  function-->

<?php   include('includes/langauges/Eng.php')  ?><!--  eng -->
<?php   include($tmpl .'header.php')  ?><!--  header-->

<?php 



    if (!isset($NoNavbar)){

        include($tmpl .'navbar.php');
    
    }

    
   








?><!--  Navbar-->


