<?php
session_start();
include("connection.php");
include('includes/functions/getshopNameBySHopID.php'); 
include('includes/functions/showMessageBox.php');
include('includes/functions/GetItemMaxQun.php');
 

if (!empty($_POST['categories'])  ) {
    $selectedCategories = $_POST['categories'];
    $catogeryID=$_POST['Category_ID'];

    // Build the IN clause for the selected categories
    $inClause = implode(',', array_map('intval', $selectedCategories));

    // Query to retrieve shops based on selected categories
    $itemsQuery = $con->prepare("SELECT i.*
    FROM item AS i
    JOIN shop AS s ON i.shopID = s.shopID
    JOIN shop_owner AS so ON s.Shop_OwnerID = so.Shop_OwnerID
    WHERE i.Quantity > 0
    AND so.Shop_owner_state = 'Active'
    AND  i.Item_state ='Active'
    AND i.Sub_Category_ID IN ($inClause) AND i.Category_ID = :categoryId
    ORDER BY i.List_date DESC;");

    $itemsQuery->bindParam(':categoryId', $catogeryID);
    $itemsQuery->execute();
    if ($itemsQuery->rowCount() > 0) {
    while ($row = $itemsQuery->fetch()) {


        $shopId=$row['shopID'];
        // Call the getShopDataByShopID() function with the desired shop ID
        $shopData = getShopDataByShopID($shopId);
        $itemID=$row['ItemID'];
        $itemMAXQ=GetItemMaxQun($itemID);
        // echo "max q=".$itemMAXQ;

        // Retrieve the shop name and image from the returned data
        $shopName = $shopData['shop_Name'];
        $shopLogo = $shopData['shop_Logo'];  //  NOTE: it get it form catogry to disply edit it later
      echo '<div class=\'col-sm-4 col-md-4  mb-2\'>
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
                      <input type="hidden" name="Price_" value=" '.$row['Price'].'">           
                      <input type="hidden" name="Title_" value="'.$row['Title'].' ">           
                      <input type="hidden" name="shopID_" value="'.$row['shopID'].' ">   
                      <input type="hidden" name="img_" value="'.$row['Item_image'].' "> 

                      <button type="submit"  name="submit_favorate" style="background: none;border: none;">  
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
                          <div class="col-sm-12 mb-2">
                              <div class="form-group mb-2 d-flex">
                                  <label for="qun" class="mr-2">Quantity:</label>
                                  <input type="number" name="qun" class="form-control" value="1" min="1" max="'.$itemMAXQ.'">                                    </div>
                          </div>
                      </div>
                      <input type="submit" name="Add_to_cart"class=\'btn btn-light \'  value="Add to cart">
                      <a href=\'item_details.php?Category_ID='.$_POST['Category_ID'].'&itemID='.$row['ItemID'].'\' class=\'btn \'>View more </a>


                  </form>               </div>            </div>
            </div>';
    }}
    else {
        echo '<div style="text-align: center; margin: 207px auto;"><h5>No items found.</h5></div>';}
    
  
} else {

    $catogeryID=$_POST['Category_ID'];
    // Print out all items if no checkbox is selected
    $allitemsQuery = $con->prepare("SELECT i.*
    FROM item AS i
    JOIN shop AS s ON i.shopID = s.shopID
    JOIN shop_owner AS so ON s.Shop_OwnerID = so.Shop_OwnerID
    WHERE i.Quantity > 0
    AND so.Shop_owner_state = 'Active'
    AND  i.Item_state ='Active'
    AND Category_ID = :categoryId
    ORDER BY i.List_date DESC;");
    $allitemsQuery->bindParam(':categoryId', $catogeryID);
    $allitemsQuery->execute();

    if ($allitemsQuery->rowCount() > 0) {
        while ($row = $allitemsQuery->fetch()) {


            
        $shopId=$row['shopID'];
        // Call the getShopDataByShopID() function with the desired shop ID
        $shopData = getShopDataByShopID($shopId);
        $itemID=$row['ItemID'];
        $itemMAXQ=GetItemMaxQun($itemID);
        // echo "max q=".$itemMAXQ;

        // Retrieve the shop name and image from the returned data
        $shopName = $shopData['shop_Name'];
        $shopLogo = $shopData['shop_Logo'];  //  NOTE: it get it form catogry to disply edit it later
         
            echo '<div class=\'col-sm-4 col-md-4  mb-2\'>
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
                        <input type="hidden" name="Price_" value=" '.$row['Price'].'">           
                        <input type="hidden" name="Title_" value="'.$row['Title'].' ">           
                        <input type="hidden" name="shopID_" value="'.$row['shopID'].' ">   
                        <input type="hidden" name="img_" value="'.$row['Item_image'].' "> 

                        <button type="submit"  name="submit_favorate" style="background: none;border: none;">  
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
                            <div class="col-sm-12 mb-2">
                                <div class="form-group mb-2 d-flex">
                                    <label for="qun" class="mr-2">Quantity:</label>
                                    <input type="number" name="qun" class="form-control" value="1" min="1" max="'.$itemMAXQ.'">                                    </div>
                            </div>
                        </div>
                        <input type="submit" name="Add_to_cart"class=\'btn btn-light \'  value="Add to cart">

                        <a href=\'item_details.php?Category_ID='.$_POST['Category_ID'].'&itemID='.$row['ItemID'].'\' class=\'btn \'>View more </a>

                    </form>                </div> </div>
            </div>';
        }
    } else {
        echo '<div style="text-align: center; margin: 207px auto;"><h5>No items found.</h5></div>';
    }
}

?>

<!--  -->


