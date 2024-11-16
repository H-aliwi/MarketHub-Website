<?php
session_start();
error_reporting(E_ERROR | E_PARSE);


if (isset($_SESSION['usernameA']) && isset($_GET['Category_ID']) && isset($_GET['itemID'])) {


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
            'quantity' => $_POST['qun_'],
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
       

    $pageTitle = "Product details";

include("intil.php");
include('includes/functions/getshopNameBySHopID.php'); 
include('includes/functions/showMessageBox.php');
include('includes/functions/GetItemMaxQun.php');
include('includes/functions/getCategryName.php');




// echo "Category_ID =". $_GET['Category_ID'];
include("connection.php");
$stat = $con->prepare("
                        SELECT i.*
                        FROM item AS i
                        JOIN shop AS s ON i.shopID = s.shopID
                        JOIN shop_owner AS so ON s.Shop_OwnerID = so.Shop_OwnerID
                        WHERE i.Quantity > 0
                        AND i.Category_ID = :category_id
                        AND so.Shop_owner_state = 'Active'
                        AND  i.Item_state ='Active'
                        AND i.ItemID = :itemID
                        ORDER BY i.List_date DESC;");
$stat->bindParam(':category_id', $_GET['Category_ID']);
$stat->bindParam(':itemID', $_GET['itemID']);

$stat->execute();

$stat_2 = $con->prepare("
    SELECT i.*
    FROM item AS i
    JOIN shop AS s ON i.shopID = s.shopID
    JOIN shop_owner AS so ON s.Shop_OwnerID = so.Shop_OwnerID
    WHERE i.Quantity > 0
        AND so.Shop_owner_state = 'Active'
        AND i.Item_state = 'Active'
        AND i.ItemID <> :itemID
        AND i.Category_ID = (
            SELECT Category_ID
            FROM item
            WHERE itemID = :itemID
        )
        AND i.Sub_Category_ID = (
            SELECT Sub_Category_ID
            FROM item
            WHERE itemID = :itemID
        );");

$stat_2->bindParam(':itemID', $_GET['itemID']);
$stat_2->execute();





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

.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: contain;
    padding: 2px;
    /* max-height:350px; */

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
    top: -33px;
    right: 3px;
    font-size: 18px;
    color: black;

}


#message-box {
    width: 450px;
    height: 212px;
    padding: 20px;
    background-color: #fff;
    border-radius: 29px;
    text-align: center;
    z-index: 9999;
    position: absolute;
    left: 340px;
    top: 100px;
}

.fa-check-circle:before,
.fa-circle-check:before {
    content: "\f058";
    font-size: 50px;
}

.hidden {
    display: none;
}

.proggress a {
    color: white;

}

.proggress a:hover {

    text-decoration: none;
    color: #white;


}
</style>

<div class="container" style="margin-top: 28px;">
    <div class="card-flex d-flex align-items-center justify-content-center mt-3 mb-3"
        style="background-color: #192a51; color: white;">
        <div class="row mx-0">
            <div class="col proggress">
            <h2 class="card-title">
    <a href="catogry_all.php">Categories</a> /
    <a href="product.php?Category_ID=<?php echo $_GET['Category_ID']; ?>">
        <?php 
        $CategryId = $_GET['Category_ID'];
        $CategryName = getCategryName($CategryId);
        echo $CategryName;
        ?>
    </a>/ Product
</h2>
            </div>
        </div>
    </div>

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


             
             
             
             ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row" style=" min-height: 550px;" id="result">

                <?php

                // Display products
                if ($stat->rowCount() > 0) {
                while ($row = $stat->fetch()) {

                    $shopId=$row['shopID'];
                    // Call the getShopDataByShopID() function with the desired shop ID
                    $shopData = getShopDataByShopID($shopId);
                    $itemID=$row['ItemID'];
                    $itemMAXQ=GetItemMaxQun($itemID);
                    // echo "max q=".$itemMAXQ;

                    // Retrieve the shop name and image from the returned data
                    $shopName = $shopData['shop_Name'];
                    $shopLogo = $shopData['shop_Logo'];  //  NOTE: it get it form catogry to disply edit it later
                    // Your PHP code here
                    
                    echo '<div class="col-sm-12 col-md-12 mb-2">
                        <div class="card">
                            <form action="" method="POST">
                                <img src="../shop_owner/layout/images/items/' . $row['Item_image'] . '" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <a href="shop_items.php?Shop_ID=' . $row['shopID'] . '">
                                        <div class="d-flex align-items-center mb-4">
                                            <img src="../shop_owner/layout/images/logo/' . $shopLogo . '" alt="Shop Logo" class="rounded-circle" style="width: 35px; height: 35px; border: 1px solid black;">
                                            <span class="ml-3">' . $shopName . '</span>
                                        </div>
                                    </a>
                                    <div class="card-flex">
                                      <h5 class="card-title"><span style="font-weight: 600;">Item name: </span> ' . $row['Title'] . '</h5>
                                        <h5 class="card-title mt-3 mb-3"><span style="font-weight: 600;">Item description: </span>' . $row['Item_description'] . '</h5>
                                        <span class="like">
                                            <form action="" method="POST">
                                                <input type="hidden" name="itemID_" value="' . $row['ItemID'] . '">
                                                <input type="hidden" name="Title_" value="' . $row['Title'] . '">
                                                <input type="hidden" name="shopID_" value="' . $row['shopID'] . '">
                                                <input type="hidden" name="img_" value="' . $row['Item_image'] . '">';
                                                if ($row['Discount_Percent'] > 0) {
                                                    $discountPercent = $row['Discount_Percent'];
                                                    $price = $row['Price'];
                                                    $discountedPrice = $price - ($price * ($discountPercent / 100));
                                                    echo '<input type="hidden" name="Price_" value="'.$discountedPrice.'">';
                                                } else {
                                                    echo '<input type="hidden" name="Price_" value="'.$row['Price'].'">';
                                                }
                                              echo'  <button type="submit" name="submit_favorate" class="like-button" style="background: none; border: none;">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                            </form>
                                        </span>
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
                                            <div class="form-group mb-2">
                                                <label for="qun" class="mr-2">Quantity:</label>
                                                <input type="number" name="qun" class="form-control" value="1" min="1" max="' . $itemMAXQ . '">
                                            </div>
                                        </div>
                                    </div>
     

                                    
                                    <input type="submit" name="Add_to_cart" class="btn btn-light" value="Add to cart">';
                                    echo '<h3 class="mt-5 mb-3"> Similar items</h3>';

                                    echo '<div class="row mx-0" >';
                                    if ($stat_2->rowCount() > 0) {
                                        while ($row = $stat_2->fetch()) {
                        
                                            // $shopId=$row['shopID'];
                                            // // Call the getShopDataByShopID() function with the desired shop ID
                                            // $shopData = getShopDataByShopID($shopId);
                                            // $itemID=$row['ItemID'];
                                            // $itemMAXQ=GetItemMaxQun($itemID);
                                            // // echo "max q=".$itemMAXQ;
                        
                                            // // Retrieve the shop name and image from the returned data
                                            // $shopName = $shopData['shop_Name'];
                                            // $shopLogo = $shopData['shop_Logo'];  //  NOTE: it get it form catogry to disply edit it later
                        
                                            echo '

                                              <div class=\'col-sm-3 col-md-3 mb-2\'>
                        
                                            <div class=\'card\' >
                                            <form action="" method="POST">
                                            <img src=\'../shop_owner/layout/images/items/'. $row['Item_image'] . '\' class=\'card-img-top\' alt=\'...\'>'
                                            . '<div class=\'card-body\'>
                                            <a href="shop_items.php?Shop_ID=' . $row['shopID'] . '">
                                            <div class="d-flex align-items-center mb-4">
                                                <img src="../shop_owner/layout/images/logo/'.$shopLogo.'" alt="Description of the image" class="rounded-circle" style="width: 35px;height: 35px;border: 1px solid black;" ">
                                                <span class="ml-3">'. $shopName.'</span>
                                             </div></a>
                                                <div class=\'card-flex \'>
                        
                                                    <h5 class=\'card-title\'s>  '.$row['Title'].'</h5>
                                                    <span class=\'like\'>
                                                    <form action="" type="Post">
                                                
                                                    <input type="hidden" name="itemID_" value="'.$row['ItemID'].' ">
                                                    <input type="hidden" name="Title_" value="'.$row['Title'].' ">           
                                                    <input type="hidden" name="shopID_" value="'.$row['shopID'].' ">   
                                                    <input type="hidden" name="img_" value="'.$row['Item_image'].' ">';
                                                    if ($row['Discount_Percent'] > 0) {
                                                        $discountPercent = $row['Discount_Percent'];
                                                        $price = $row['Price'];
                                                        $discountedPrice = $price - ($price * ($discountPercent / 100));
                                                        echo '<input type="hidden" name="Price_" value="'.$discountedPrice.'">';
                                                    } else {
                                                        echo '<input type="hidden" name="Price_" value="'.$row['Price'].'">';
                                                    }
                        
                                                    echo '     <button type="submit"  name="submit_favorate" style="background: none;border: none;">  
                                                    <i class=\'fa-regular fa-heart\'></i>
                                                    </button> </span></form>
                                                
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
                                            
                                            
                                                    </div>
                        
                        
                                                <a href=\'item_details.php?Category_ID='.$_GET['Category_ID'].'&itemID='.$row['ItemID'].'\' class=\'btn \'>View more </a>
                                                </form>
                                            </div>
                                            </div>                                            

                                        </div>';
                                        }
                                        }
                        
                                        else {
                                            echo
                                            '<div style="text-align: center;
                                            margin: 20px auto;"> <h5>  No items found.</h5>
                                           </div>';
                                        }
                        
                                        ?>
                                    </div>
                                </div>




                             <?php echo  '</div>
                            </form>
                        </div>
                    </div>';
                    
                }
                }

                else {
                    echo
                    '<div style="text-align: center;
                    margin: 207px auto;"> <h5>  No items have been added yet.</h5>
                   </div>';
                }

                ?>
            </div>
        </div>






    </div>

</div>

<!-- 
<section name="footer">
    <div class=" p-3  text-center" style="  background-color: #192a51; ">
        <p style=" color: aliceblue;">&copy; 2023 BSE Shop. All rights reserved. | Desigend by Hussain Aliwi</p>
    </div>
</section> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php




    include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>