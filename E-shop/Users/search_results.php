<?php
session_start();
if(isset($_SESSION['usernameA'])){
    $pageTitle = "search";
    $NoFooter ="";

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
    $itemID = $_POST['itemID_'];

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




      
    include("intil.php") ;  //<!--  rounter -->
    include('includes/functions/getshopNameBySHopID.php'); 
    include('includes/functions/showMessageBox.php');
    include('includes/functions/GetItemMaxQun.php');

    include("connection.php");
?>

<style>

.like{
        position: absolute;
        top: -33px;
        right: 3px;
        font-size: 18px;
        color: black;
        
    }

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
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
  .card-img-top{
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

    .card-container {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    justify-content: space-between;
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

</style>
<?php
  
  if(isset($_SESSION['show_message'])){
      $message="Item added to cart successfully.";
  }
  else if (isset($_SESSION['show_message_Fav'])){
      $message="Item added to Favorite successfully.";

  }


?>

<div class="container">
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
    



if (isset($_SESSION['search_results'])) {


  
  $matchingItems = $_SESSION['search_results'];

  echo '<h2 class="mt-3">Search result for <span class="search-query" style="font-weight: 600;">'.$_GET['search'].'</span></h2>';

  // Display the search results
  
  if (!empty($matchingItems)) {
    echo '      <div class="row" style="min-height: 550px;">    ';
    foreach ($matchingItems as $item) {

      ?> 
  <?php
  $shopId = $item['shopID'];
  // Call the getShopDataByShopID() function with the desired shop ID
  $shopData = getShopDataByShopID($shopId);
  $itemID = $item['ItemID'];
  $itemMAXQ = GetItemMaxQun($itemID);
  // echo "max q=".$itemMAXQ;

  // Retrieve the shop name and image from the returned data
  $shopName = $shopData['shop_Name'];
  $shopLogo = $shopData['shop_Logo']; //  NOTE: it get it form catogry to disply edit it later
  echo '<div class=\'col-sm-4 col-md-4 col-lg-3 mb-2\'>
          <div class=\'card\'>
            <form action="" method="POST">
              <img src=\'../shop_owner/layout/images/items/' . $item['Item_image'] . '\' class=\'card-img-top\' alt=\'...\'>
              <div class=\'card-body\'>
                <a href="shop_items.php?Shop_ID=' . $item['shopID'] . '">
                  <div class="d-flex align-items-center mb-4">
                    <img src="../shop_owner/layout/images/logo/' . $shopLogo . '" alt="Description of the image" class="rounded-circle" style="width: 35px;height: 35px;border: 1px solid black;">
                    <span class="ml-3">' . $shopName . '</span>
                  </div>
                </a>
                <div class=\'card-flex \'>

                <h5 class=\'card-title\'s>  '.$item['Title'].'</h5>
                <span class=\'like\'>
                <form action="" type="Post">
            
                <input type="hidden" name="itemID_" value="'.$item['ItemID'].' ">
                <input type="hidden" name="Price_" value=" '.$item['Price'].'">           
                <input type="hidden" name="Title_" value="'.$item['Title'].' ">           
                <input type="hidden" name="shopID_" value="'.$item['shopID'].' ">   
                <input type="hidden" name="img_" value="'.$item['Item_image'].' "> 

                <button type="submit"  name="submit_favorate" style="background: none;border: none;">  
                <i class=\'fa-regular fa-heart\'></i>
                </button> </span></form>
            
               </div> 
               <input type="hidden" name="itemID" value="'.$item['ItemID'].' ">
               <input type="hidden" name="Title" value="'.$item['Title'].' ">           
               <input type="hidden" name="shopID" value="'.$item['shopID'].' ">   
               <input type="hidden" name="img" value="'.$item['Item_image'].' ">'; 
               if ($item['Discount_Percent'] > 0) {
                   $discountPercent = $item['Discount_Percent'];
                   $price = $item['Price'];
                   $discountedPrice = $price - ($price * ($discountPercent / 100));
                   echo '<input type="hidden" name="Price" value="'.$discountedPrice.'">';
               } else {
                   echo '<input type="hidden" name="Price" value="'.$item['Price'].'">';
               }

   
 

                 echo ' <div class="row p-0">
                   <div class="col-sm-12 mb-2"style="font-weight: bold;">';
                   if ($item['Discount_Percent'] > 0) {
                       $discountPercent = $item['Discount_Percent'];
                       $price = $item['Price'];
                       $discountedPrice = $price - ($price * ($discountPercent / 100));
                       echo '  <div class="row discountedPrice">
                       <div class="col">
                       <span class="price-after-discount mr-3 mb-0" style="font-weight: bold; ">Price:'.$discountedPrice.'</span><br>
                       <span class="old-price" style="font-size: 12px;text-decoration: line-through;">'.$item['Price'].'</span>
                       <span class="discount" style="font-size: 12px;color: #ff0000bd;">('.$item['Discount_Percent'].'% OFF)</span>
                       </div>
                     </div>';
                   } else {
                       echo '<h6 class="mb-0" style="font-weight: bold;">Price: ' . $item['Price'] . ' BD</h6>';
                   }

       
              echo '</div>
                  <div class="col-sm-12 mb-2">
                    <div class="form-group mb-2 d-flex">
                      <lable for="qun" class="mr-2">Quantity:</lable>
                      <input type="number" name="qun" class="form-control" value="1" min="1" max="' . $itemMAXQ . '">
                    </div>
                  </div>
                </div>
                <input type="submit" name="Add_to_cart" class=\'btn btn-light \'  value="Add to cart">
                <a href=\'item_details.php?Category_ID='.$item['Category_ID'].'&itemID='.$item['ItemID'].'\' class=\'btn \'>View more </a>
                </div>
            </form>
        </div>';
  ?>
</div>

    <?php
      // // Code to display the item details
      // echo '<div class="item">';
      // echo '<h3>' . $item['Title'] . '</h3>';
      // // Display other item details as needed
      // echo '</div>';
    }
  } else {
    echo '<p>No matching items found.</p>';
  }

  // Clear the search results from the session
  // unset($_SESSION['search_results']);
} else {
  echo '<p>No search results found.</p>';
}




?>
    <?php include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>