<?php
    session_start();
    $pageTitle = "Admin Profile";
    include("intil.php");

   
    // $username = $_SESSION['username'];
    // $email = $_SESSION['email'];

?>

    <section class='dashboard'>
        <div style="display: flex; justify-content:space-between">
    <div>
        <h1>Profile</h1>
    </div>
    <div style="margin:2rem">
        <a href="#">Edit profile</a>
    </div>
    </div>
    <div class="container profile" style="margin-top:4rem;">

        <h5> <?php //echo "Email: " . $email . ""; ?></h5><br>
        <!-- <h5>Gender : </h5><br> -->
        <h5>Password : 
        <a href="#">Change your password         
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
         </h5><br>
        <h5>NO. of shops : <!-- sql --> </h5><br><br>



    </div>

    </section>