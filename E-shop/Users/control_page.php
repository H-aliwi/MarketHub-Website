<?php
session_start();
if(isset($_SESSION['usernameA'])){
    $pageTitle = "Home page";

    include("intil.php") ;  //<!--  rounter -->
// echo  "ID :".$_SESSION['UserID']; 
include("connection.php");
$stat = $con->prepare("SELECT * FROM category");
$stat->execute();

$stat_2 = $con->prepare("SELECT i.*
FROM item AS i
JOIN shop AS s ON i.shopID = s.shopID
WHERE i.Quantity > 0
AND  i.Item_state ='Active'
ORDER BY i.List_date DESC LIMIT 8;");
$stat_2->execute();


?>

<style>

    .carousel a{
           color: ;

    }
</style>

        <section class="Test">   
        <div class="banner">
                <h2> Sell and Buy Goods at MarketHub!</h2>
                <p>Transform your shopping experience with MarketHub, where you can sell and buy a wide range of products. </p>
                <div id="bannerbtn">  <a href="Control_Register.php"><button id="bannerButton"> Get Started</button></a> 
            </div>
        </div>

        </section>


        <div class="container mt-4" style="padding: 30px;">


  <h2 style="margin: 15px 10px; font-size:28px;">Categories</h2>
            <div class="wrapper">

            <i id="left"class="fa-solid fa-angle-left"></i>
            <ul class="carousel">
            <?php

                    // Display category
                    if ($stat->rowCount() > 0) {
                    while ($row = $stat->fetch()) {
                        echo ' 
                        <a href="product.php?Category_ID=' . $row['Category_ID'] . '">                        <li class="card">
                        <div class="img"><img src="../shop_owner/layout/images/catogry/'.$row['Category_image'].' " alt="img" draggable="false"></div>
                        <h2>'.$row['Category_name'].'</h2>
                                </li>
                                </a>';
                        
                    }
                    }

                    ?>
    
            </ul>
            <i id="right" class="fa-solid fa-angle-right"></i>
            </div>   
                <div class="row ">
                <div class="col-md-12 text-sm-center  text-md-right  ">
                <a href="catogry_all.php"> <h4 style="margin-top: -15px; font-size:20px;">View All </h4></a>
                </div>     
                </div>
            </div>

            </div> 




  
  

  <div class="container" style="padding: 30px;">
    <h2 style="margin: 10px 10px; font-size:28px;"> Recent products  </h2>
    <div class="row">


          <?php
  
      // Display category
      if ($stat_2->rowCount() > 0) {
      while ($row = $stat_2->fetch()) {
          echo '
          <div class="col-md-3">
              <div class="product-box-Allitem">
              <a style="background: none;" href=\'item_details.php?Category_ID='.$row['Category_ID'].'&itemID='.$row['ItemID'].'\' class=\'btn \'>
              <img src=\'../shop_owner/layout/images/items/'. $row['Item_image'] . '\' class=\'card-img-top\' alt=\'...\'>

              </a>

              </div>
             </div> ';
          
      }
      }
      if (isset($_SESSION['show_message_newForm'])) {
        echo "<script>alert('Your request has been sent successfully.');</script>";

         unset($_SESSION['show_message_newForm']); // Reset the session variable
     }

      ?>
      

    </div>
 

    <div class="row ">
      <div class="col-md-12 text-sm-center  text-md-right  ">
      <!-- <a href="#"> <h4 style="margin-top: -15px; font-size:20px;">View All </h4></a> -->
      </div>
    </div>

</div>







  <div class="container" style="padding: 30px;" id='target-FAQs'>
    <h2 style="margin: 20px 20px;font-size:28px;">Frequently Asked Questions</h2>
    <div id="accordion">
      <div class="card">
        <div class="card-header">
          <a class="card-link" data-toggle="collapse" href="#collapse1">
          Question 1: How can I open a shop on the MarketHub website?          </a>
        </div>
        <div id="collapse1" class="collapse " data-parent="#accordion">
          <div class="card-body">
          Answer 1:
          <br>
           1. Visit the MarketHub website and send a request to open shop.
          <br><br>
          2. Fill in the necessary details, such as your shop name, description, payment preferences, 
          <br>and what you want to sell. Submit the form to open your shop. 
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <a class="card-link" data-toggle="collapse" href="#collapse2">
          Question 2: After shop approval, what features in MarketHub's shop owner dashboard?
          </a>
        </div>
        <div id="collapse2" class="collapse" data-parent="#accordion">
          <div class="card-body">
          Answer 2: Once your shop request is accepted and you log in to your shop owner dashboard on MarketHub, you will have access to various features and options, like Add Items,Generate Reports, and others.          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <a class="card-link" data-toggle="collapse" href="#collapse3">
            Question 3: Are there any fees associated with listing items  on MarketHub?
          </a>
        </div>
        <div id="collapse3" class="collapse" data-parent="#accordion">
          <div class="card-body">
            Answer 3: MarketHub take fees 4% only on shop sold items.
          </div>
        </div>
      </div>
      <div class="card">
        <!-- <div class="card-header">
          <a class="card-link" data-toggle="collapse" href="#collapse4">
            Question 4
          </a>
        </div> -->
        <div id="collapse4" class="collapse" data-parent="#accordion">
          <div class="card-body">
            Answer 4
          </div>
        </div>
      </div>
    </div>
  </div>




<?php

?>



<?php



    include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>




