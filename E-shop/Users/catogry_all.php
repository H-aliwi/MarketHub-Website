<?php
session_start();
if (isset($_SESSION['usernameA'])) {
    $pageTitle = "Catogery Page";

include("intil.php");

// echo "Category_ID =". $_GET['Category_ID'];
include("connection.php");
$stat = $con->prepare("SELECT * FROM category");
$stat->execute();

?>

<!-- <section name="second-navbar" >
    <div class="nav navbar navbar-expand-lg  navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
            <li class="nav-item" >
                <a class="nav-link" href="#"> welcome Goust</a>

            </li>
            <li class="nav-item" >
                <a class="nav-link" href="#"> Login</a>

            </li>
        </ul>
    </div>
</section> -->

<style>
    
  .card-img-top{
     width: 100%;
    height: 200px;   
    object-fit: contain;   
    padding: 2px;
    max-height: 195px;

    }

    .card-flex {
        position: relative;
        /* display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%; */
    }
    .like{
        position: absolute;
        top: -9px;
        right: 3px;
        font-size: 18px;
        color: black;
        
    }


</style>
<div class="container" style="margin-top: 28px; background-color: white; padding-left: 0; padding-right: 0;">
  <div class="card-flex d-flex align-items-center justify-content-center mt-3 mb-3" style="background-color: #192a51; color: white;">
    <div class="row mx-0">
      <div class="col">
        <h2 class="card-title">Categories</h2>
      </div>
    </div> 
  </div>
  <div class="row mx-0">
    <?php 
    if ($stat->rowCount() > 0) {
      while ($row = $stat->fetch()) {
        echo '<div class="col-sm-6 col-md-3 col-lg-3 mb-2 cotogry">
                <a href="product.php?Category_ID='.$row['Category_ID'].'" > 
                <div class="card photo">
              <img src="../shop_owner/layout/images/catogry/'.$row['Category_image'].'" class="card-img-top "  alt="...">
                  <div class="card-body">
                  </div>
                  <div class="card-flex d-flex align-items-center justify-content-center">
                    <h5 class="card-title">'.$row['Category_name'].'</h5>
                  </div>
                </div></a>
              </div>';
      }
    } else {
      echo '<div style="text-align: center; margin: 207px auto;">         
              <h5>ERROR OCCURRED</h5>
            </div>';
    }
    ?>
  </div>
</div>

<!-- <section name="footer"> 
    <div class=" p-3  text-center" style="  background-color: #192a51; " >
    <p style=" color: aliceblue;">&copy; 2023 BSE Shop. All rights reserved. | Desigend by Hussain Aliwi</p>
    </div>
</section> -->


<?php



    include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>
