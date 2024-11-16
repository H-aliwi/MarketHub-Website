<?php
session_start();
if (isset($_SESSION['usernameA']) && isset($_GET['Shop_ID'])) {
    $pageTitle = "shop items";


    if (isset($_POST['Add_to_cart'])) {
        $itemID = $_POST['itemID'];
    
        $item_array = array(
            "item_id" => $itemID,
            "item_name" => $_POST['Title'],
            'item_price' => $_POST['Price'],
            'item_img' => $_POST['img'],
            'quantity' => $_POST['qun'],
            'shopID' => $_POST['shopID']
        );
    
        $cart_data = array();
        if (isset($_COOKIE['shopping_cart'])) {
            $cart_data = json_decode($_COOKIE['shopping_cart'], true);
        }
    
        // Check if the item already exists in the cart
        $item_exists = false;
        foreach ($cart_data as $cart_item) {
            if ($cart_item['item_id'] == $itemID) {
                $item_exists = true;
                break;
            }
        }
    
        if ($item_exists) {
            // Item already exists in the cart, show a message
            $_SESSION['show_item_exisit'] =true;
        } else {
            $cart_data[] = $item_array;
            $item_data = json_encode($cart_data); // Encode the cart data to JSON
            setcookie('shopping_cart', $item_data, time() + (86400 * 30)); // Store the encoded JSON data in the cookie
            $_SESSION['show_message'] =true;

        }
    }
     // ADD to favorate
     if (isset($_POST['submit_favorate'])) {
        $itemID = $_POST['itemID'];

        $item_array = array(
            "item_id" => $itemID,
            "item_name" => $_POST['Title_'],
            'item_price' => $_POST['Price_'],
            'item_img' => $_POST['img_'],
            'shopID' => $_POST['shopID_']
        );
    
        $Fav_data = array();
        if (isset($_COOKIE['Favorate'])) {
            $Fav_data = json_decode($_COOKIE['Favorate'], true);
        }
    
        // Check if the item already exists in the cart
        $item_exists = false;
        foreach ($Fav_data as $cart_item) {
            if ($cart_item['item_id'] == $itemID) {
                $item_exists = true;
                break;
            }
        }
    
        if ($item_exists) {
            // Item already exists in the cart, show a message
            $_SESSION['show_item_exisit_Fav'] =true;
        } else {
            $Fav_data[] = $item_array;
            $item_data = json_encode($Fav_data); // Encode the cart data to JSON
            setcookie('Favorate', $item_data, time() + (86400 * 30)); // Store the encoded JSON data in the cookie
            $_SESSION['show_message_Fav'] =true;
        }
    }


   // END

include("intil.php");?>

</div><?php
include('includes/functions/getshopNameBySHopID.php'); 
include('includes/functions/showMessageBox.php');
include('includes/functions/showMessageBoxRate.php');

include('includes/functions/GetItemMaxQun.php');



// echo "Category_ID =". $_GET['Category_ID'];
include("connection.php");
$stat = $con->prepare("SELECT * FROM item WHERE  Quantity > 0 AND  Item_state ='Active' AND shopID = :shopID ORDER BY List_date DESC");
$stat->bindParam(':shopID', $_GET['Shop_ID']);
$stat->execute();



$stat_2 = $con->prepare("SELECT * FROM shop WHERE shopID =? ");

                              
 $stat_2->execute(array($_GET['Shop_ID']));
 $row=$stat_2->fetch();     // get Data from DB
 $count= $stat_2->rowCount();  // if user is exesis it will count  1  and it is admin GroupID=1

if($count >0){

    $shop_name=$row['shop_Name'];
    $shop_Logo=$row['shop_Logo'];
    $shop_Description=$row['shop_Description'];
    $shop_rate=$row['rate'];
    $shopID=$row['shopID'];



}
// inserting shop rate
if (isset($_POST['sumbmit_rate']) ) {
        // Retrieve the form data
        $customerID = $_SESSION['UserID'];
        $shopID = $shopID;
        $comment = $_POST['comment'];
        $noOfStars = $_POST['noOfStars'];

        // Insert the data into the database
        $sql = "INSERT INTO shop_rate (CustomerID, shopID, Comment, No_of_stars, Rate_date)
                VALUES (:CID, :SIDD, :Commnt, :Cstar,NOW())";

    $stmt = $con->prepare($sql);

    $stmt->bindParam(':CID', $customerID, PDO::PARAM_STR);
    $stmt->bindParam(':SIDD', $shopID, PDO::PARAM_STR);
    $stmt->bindParam(':Commnt', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':Cstar', $noOfStars, PDO::PARAM_STR);


    if ($stmt->execute()) {
        $_SESSION['show_message_new_rate'] = true;
        
        // echo "<script>alert('Thank you for rating this shop');</script>";

    } 
    else {
        echo "<script>alert('Error happen');</script>";
    }

}


// END insering shop rate


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
<!-- message new rate -->
<div id="message-box-rate" class="hidden-rate">
    <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
    <h2>SUCCESS!</h2>
    <p style="color: #808080;">Thank you for rating this shop.</p>
    <button onclick="closeMessageBoxNewRate()"
        style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
</div>
<!-- End -->
<!-- SHOP RATE POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Rate shop</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" >
                <div class="modal-body">
                    <input type="hidden" name="shopID" id="shopID" value="<?php echo $shopID;?>">

                    <div class="form-group">
                        <label for="noOfStars">Number of Stars</label>
                        <input class="form-control-rate" type="number" name="noOfStars" min="1" max="5"
                            placeholder="Number of stars" required>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control-rate" name="comment" rows="5" cols="33" placeholder="Comment"
                            required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="sumbmit_rate" class="btn">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>


<style>
.form-control {
    display: block;
    width: 60px;
    height: 36px;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #192a51;
    background-color: #Eaeaea;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.form-control-rate {
    display: block;
    width: 436px;
    height: 36px;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #192a51;
    background-color: #Eaeaea;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: contain;
    padding: 2px;
    max-height: 165px;

}

.card-flex {
    position: relative;
    /* display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%; */
}

.like {
    position: absolute;
    top: -20px;
    right: 3px;
    font-size: 18px;
    color: black;

}

.chat-p a {
    color: white;

}

.chat-p a:hover {

    text-decoration: none;
    color: #007bff;
    ;

}

#message-box,
#message-box-rate {
    width: 450px;
    height: 212px;
    padding: 20px;
    background-color: #fff;
    border-radius: 29px;
    text-align: center;
    z-index: 9999;
    position: absolute;
    left: 460px;
    top: 330px;
}

.fa-check-circle:before,
.fa-circle-check:before {
    content: "\f058";
    font-size: 50px;
}

.hidden,
.hidden-rate {
    display: none;
}
.fa-star:before {
    content: "\f005";
    color: #FFDF00;
    font-size: 22px;
}

</style>

<div class="container ">
<?php
    if(isset($_SESSION['show_message'])){
        $message="Item added to cart successfully.";
    }
    else if (isset($_SESSION['show_message_Fav'])){
        $message="Item added to Favorite successfully.";

    }


  ?>
    <div id="message-box" class="hidden">
        <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
        <h2>SUCCESS!</h2>
        <p style="color: #808080;"><?php echo $message ?></p>
        <button onclick="closeMessageBox()"
            style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
    </div>

    <?php
    if(isset($_SESSION['show_item_exisit'])){
        $message_fav=" Item already added in cart.";
    }
    else if (isset($_SESSION['show_item_exisit_Fav'])){
        $message_fav=" Item already added in Favorite list.";

    }

           
             if(isset($_SESSION['show_item_exisit']))
             {    
                 echo '<div class="alert alert-warning">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                   <strong>Warning!</strong> '. $message_fav.'.
                     </div>';
                 unset($_SESSION['show_item_exisit']); // Reset the session variable
        
              }

              if(isset($_SESSION['show_item_exisit_Fav']))
              {    
                  echo '<div class="alert alert-warning">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> '. $message_fav.'
                      </div>';
                  unset($_SESSION['show_item_exisit_Fav']); // Reset the session variable
         
               }

              if(isset($_SESSION['show_message']) )
              {    
                  showMessageBox(); 
                  unset($_SESSION['show_message']); // Reset the session variable
         
               }
               if(isset($_SESSION['show_message_Fav']) )
               {    
                   showMessageBox(); 
                   unset($_SESSION['show_message_Fav']); // Reset the session variable
          
                }

               
              if(isset($_SESSION['show_message_new_rate']))
              {    
                showMessageBoxRate(); 
                  unset($_SESSION['show_message_new_rate']); // Reset the session variable
         
               }


            //    Get shop rate
        $sql = "SELECT AVG(No_of_stars) AS average_rating ,COUNT(*) AS total_records
        FROM shop_rate
        WHERE shopID = $shopID";
        $result = $con->query($sql);
         
        if ($result) {
            $row = $result->fetch();
            $Trate= $row['total_records'];
            $averageRating = number_format($row['average_rating'], 1);  
        } else {
            echo "Error: " . $con->error;
        }
            //       END
               



?>

    <div class="container mt-3 bg-white"
        style="width: 90%;min-height: 300px;border: 1px solid #757D75;border-radius: 16px;">
        <div class="row justify-content-start align-items-center p-4">
            <div class="col-md-6">
                <img src="../shop_owner/layout/images/logo/<?php echo $shop_Logo ?> " alt="Shop Logo "
                    class="img-fluid rounded-circle " style=" border: 1px solid black;width: 140px;">

                <h2 class="R-h2"><?php echo $shop_name ?> Shop</h2>
                <a href="chat_prosses.php?shopID=<?php echo $shopID?>" class="btn btn-light ">
                    Chat <i class="fa-solid fa-comments"></i> </a>
                <!-- <button class="btn" name="chat">Chat  <i class="fa-solid fa-comments"></i> -->
                </button>
                <button class="btn" id="rateShop" name="chat">Rate this shop</button>
            </div>

            <div class="col-md-6">
                <h4>Shop Description:</h4>
                <p><?php echo $shop_Description ?></p>
                <h4 class="d-flex">Shop Rate: <p class="ml-2"><?php echo $averageRating ?> 
                <span><i class="fa-solid fa-star"></i></span> </p>
                <span><p style="font-size: 13px;display: contents;">
                    <?php 
                    if ($Trate > 0) {
                        echo '(' . $Trate . ')';
                    }
                        
                        ?>
                    </p></span>
                </h4>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-10">
            <div class="row" style="
    min-height: 550px;
">

                <?php

                // Display products
                if ($stat->rowCount() > 0) {
                while ($row = $stat->fetch()) {

                    $shopId=$row['shopID'];


                    $shopId=$row['shopID'];
                    $itemID=$row['ItemID'];
                    $itemMAXQ=GetItemMaxQun($itemID);
                    // Call the getShopDataByShopID() function with the desired shop ID
                    $shopData = getShopDataByShopID($shopId);

                    // Retrieve the shop name and image from the returned data
                    $shopName = $shopData['shop_Name'];
                    $shopLogo = $shopData['shop_Logo'];  //  NOTE: it get it form catogry to disply edit it later

                    echo '  <div class=\'col-sm-6 col-md-6 col-lg-4 mb-2\'>

                    <div class=\'card\' >
                    <form action="" method="POST">
                        <img src=\'../shop_owner/layout/images/items/' . $row['Item_image'] . '\' class=\'card-img-top\' alt=\'...\'>'
                        . '<div class=\'card-body\'>
                        
            
                            <div class=\'card-flex \'>

                                <span class=\'like\'>
                                <form action="" type="Post">
                            
                                <input type="hidden" name="itemID_" value="'.$row['ItemID'].' ">
                                <input type="hidden" name="Price_" value=" '.$row['Price'].'">           
                                <input type="hidden" name="Title_" value="'.$row['Title'].' ">           
                                <input type="hidden" name="shopID_" value="'.$row['shopID'].' ">   
                                <input type="hidden" name="img_" value="'.$row['Item_image'].' "> 
    
                                <button type="submit"  name="submit_favorate" style="background: none;border: none;">  
                                <i class=\'fa-regular fa-heart\'></i>
                                </button> </span></form>
                                <h5 class=\'card-title\'>'.$row['Title'].'</h5>

                            </div>
                            <input type="hidden" name="itemID" value="'.$row['ItemID'].' ">
                            <input type="hidden" name="Title" value="'.$row['Title'].' ">           
                            <input type="hidden" name="shopID" value="'.$row['shopID'].' ">   
                            <input type="hidden" name="img" value="'.$row['Item_image'].' ">'; 
                            if ($row['Discount_Percent'] > 0) {
                                $discountPercent = $row['Discount_Percent'];
                                $price = $row['Price'];
                                $discountedPrice = $price - ($price * ($discountPercent / 100));
                                echo '<input type="hidden" name="Price" value="'.$discountedPrice.'">';
                            } else {
                                echo '<input type="hidden" name="Price" value="'.$row['Price'].'">';
                            }
    
                
              
            
                              echo ' <div class="row p-0">
                                <div class="col-sm-12 mb-2"style="font-weight: bold;">';
                                if ($row['Discount_Percent'] > 0) {
                                    $discountPercent = $row['Discount_Percent'];
                                    $price = $row['Price'];
                                    $discountedPrice = $price - ($price * ($discountPercent / 100));
                                    echo '  <div class="row discountedPrice">
                                    <div class="col">
                                    <span class="price-after-discount mr-3 mb-0" style="font-weight: bold; ">Price:'.$discountedPrice.'</span>
                                    <span class="old-price" style="font-size: 12px;text-decoration: line-through;">'.$row['Price'].'</span>
                                    <span class="discount" style="font-size: 12px;color: #ff0000bd;">('.$row['Discount_Percent'].'% OFF)</span>
                                    </div>
                                  </div>';
                                } else {
                                    echo '<h6 class="mb-0" style="font-weight: bold;">Price: ' . $row['Price'] . ' BD</h6>';
                                }
        
                    
                           echo '</div>
                                    <div class="col-sm-12 mb-2">
                                        <div class="form-group mb-2 d-flex">
                                            <label for="qun" class="mr-2">Quantity:</label>
                                            <input type="number" name="qun" class="form-control" value="1" min="1" max="'.$itemMAXQ.'">                                    </div>
                                    </div>
                                </div>
                                <input type="submit" name="Add_to_cart"class=\'btn btn-light \'  value="Add to cart">

                                <a href=\'item_details.php?Category_ID='.$row['Category_ID'].'&itemID='.$row['ItemID'].'\' class=\'btn \'>View more </a>
                                </form>

                    </div>
                    </div>
                </div>';
                }
                }

                else {
                    echo
                    '<div style="text-align: center;
                    margin: 207px auto;">  Shop not have items yet. </div>';
                }

                ?>


            </div>


        </div>

        <div class="col-md-2 bg-secondary p-0 d-none">
            <ul class="navbar-nav me-auto text-center  ">
                <li style="background-color: #192a51;" class="vab-item">
                    <h4 style="
                                            color: aliceblue;
                                    ">
                        Catogeries</h4>


                </li>
                <li class="nav-item">
                    <a href="">
                        <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                            sub-Catogeries 1</h4>
                    </a>

                </li>
                </li>
                <li class="nav-item">
                    <a href="">
                        <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                            sub-Catogeries 2</h4>
                    </a>

                </li>
                </li>
                <li class="nav-item">
                    <a href="">
                        <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                            sub-Catogeries 3</h4>
                    </a>

                </li>
                </li>
                <li class="nav-item">
                    <a href="">
                        <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                            sub-Catogeries 4</h4>
                    </a>

                </li>
            </ul>
            <ul class="navbar-nav me-auto text-center mt-3 ">
                <li style="background-color: #192a51;" class="vab-item">
                    <h4 style=" color: aliceblue">
                        Filter</h4>


                </li>
                <li class="nav-item mt-2 ">
                    <div class="form-group ">
                        <label for="inputState">
                            <h4 style=" color: aliceblue;font-size: 18px;margin-top: 8px">
                                ....:</h4>
                        </label>
                        <select id="inputState">
                            <option selected>Choose...</option>
                            <option>Manama</option>
                            <option>Moharaq</option>
                            <option>Hamad Town</option>


                        </select>
                    </div>

                </li>

            </ul>


        </div>



    </div>

</div>


<!-- <section name="footer">
    <div class=" p-3  text-center" style="  background-color: #192a51; ">
        <p style=" color: aliceblue;">&copy; 2023 BSE Shop. All rights reserved. | Desigend by Hussain Aliwi</p>
    </div>
</section> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
$(document).ready(function() {
    $('#rateShop').on('click', function() {
        var customerId =
            <?php echo $_SESSION['UserID']; ?>; // Retrieve the customer ID from PHP session
        var shopId = <?php echo $shopID; ?>; // Assign the shop ID from the PHP variable $shopID
        var username =
            "<?php echo $_SESSION['usernameA']; ?>"; // Retrieve the username from PHP session

        $.ajax({
            url: 'check_rate.php',
            method: 'POST',
            data: {
                customerID: customerId,
                shopID: shopId
            },
            success: function(response) {
                if (response === 'rated') {
                    alert('Dear ' + username + ', you already rated this shop.');
                } else {
                    $('#rateModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
</script>

<?php





    include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>