<?php
session_start();
$NoNavbar ="";  // if this var exsit it will not add navbar to this page.
$pageTitle = "";
$NoFooter =""; 

?>
<?php   include("intil.php")    ?><!--  rounter -->

<style>
    .buttons_R a{
    background-color: #192a51;
    color: white;
    padding: 6px 46px;
    text-align: center;
    text-decoration: none;
    display: inline-block;

    border: 1px solid transparent;
    font-size: 16px;
    line-height: 1.5;
    border-radius: 0.25rem;
    }
</style>

<div class="bg-form"style="    
    min-height: 450px; min-height: 400px;
    display: flex;
    align-content: flex-end;
    flex-wrap: nowrap;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: space-between;">

<!-- action to same page  BY echo $_SERVER['PHP_SELF']  -->
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="POST">
<h2  style="font-size:35px;" >Register As ? </h2>
<div class="row  buttons_R">

    <div class="col">
       <a href="Register_shop.php" >Shop Owner</a>

    </div>
    <div class="col"> 
    <a href="Register.php" >Customer</a>
    </div>
</div>
<hr>

<h6>Already have account? <a href="index.php"> <h6 style="color:blue; ">Login now</h6></a></h6>

</form>
</div>





<?php   include($tmpl .'footer.php')  ?><!-- footer -->











