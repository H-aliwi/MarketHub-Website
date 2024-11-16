<?php
session_start();
include("connection.php");
include('includes/functions/getCategryName.php'); 



if (!empty($_POST['categories'])) {
    $selectedCategories = $_POST['categories'];

    // Build the IN clause for the selected categories
    $inClause = implode(',', array_map('intval', $selectedCategories));

    // Query to retrieve shops based on selected categories
    $shopQuery = $con->prepare("SELECT * FROM shop s , Shop_Owner so
    WHERE s.Shop_OwnerID =so.Shop_OwnerID  and so.Shop_owner_state ='Active' and s.shopID IN (SELECT shopID FROM shop_category WHERE Category_ID IN ($inClause))");
    $shopQuery->execute();
    if ($shopQuery->rowCount() > 0) {
    while ($row = $shopQuery->fetch()) {
      // Code to display the shop
      // Modify this part according to your needs
      echo '<div class=\'col-sm-4 col-md-4  mb-2\'>
              <div class=\'card\' >
              <form action="" method="POST">
              <img src=\'../shop_owner/layout/images/logo/'. $row['shop_Logo'] . '\' class=\'card-img-top\' alt=\'...\'>
              <div class=\'card-body\'>
                  <a href="shop_items.php?Shop_ID=' . $row['shopID'] . '">
                      <div class="d-flex align-items-center mb-4">
                          <img src="../shop_owner/layout/images/logo/'.$row['shop_Logo'].'" alt="Description of the image" class="rounded-circle" style="width: 35px;height: 35px;border: 1px solid black;">
                          <span class="ml-3">'. $row['shop_Name'].'</span>
                      </div>
                  </a>
              
                  <input type="hidden" name="shopID" value="'.$row['shopID'].'"> 
  
                  <div class="row p-0">
                      <div class="col-sm-12 mb-2">
                          <h6 style="font-weight: bold;">Shop category:</h6>
                          <h6 class="mb-0" style="font-weight: 400; color:#757D75;">';
          
                          // Fetch and display shop categories for each shop
                          $shopCategoriesQuery = $con->prepare("SELECT Category_ID FROM shop_category WHERE shopID = ?");
                          $shopCategoriesQuery->execute([$row['shopID']]);
                          $categoryCount = $shopCategoriesQuery->rowCount();
                          
                          if ($categoryCount > 0) {
                              $categories = $shopCategoriesQuery->fetchAll(PDO::FETCH_COLUMN);
                              foreach ($categories as $index => $categoryID) {
                                  $Category_name = getCategryName($categoryID);
                                  echo $Category_name;
                                  if ($index < $categoryCount - 1) {
                                      echo ', ';
                                  } else {
                                      echo '.';
                                  }
                              }
                          } else {
                              echo 'No category assigned.';
                          }
  
                  echo '</h6>
                      </div>
                      <div class="col-sm-12 mb-2">
                          <div class="form-group mb-2 d-flex">
                          </div>
                      </div>
                     
                      <a href=\'shop_items.php?Shop_ID='.$row['shopID'].'\' class=\'btn ml-3\'>Visit shop </a>
                  </div>
              </div>
          </form>                </div>            </div>
            </div>';
    }}
    else {
        echo '<div style="text-align: center; margin: 207px auto;"><h5>No shops found.</h5></div>';}
    
  
} else {
    // Print out all shops if no checkbox is selected
    $allShopsQuery = $con->prepare("SELECT * FROM shop s , Shop_Owner so
    WHERE s.Shop_OwnerID =so.Shop_OwnerID  and so.Shop_owner_state ='Active';");
    $allShopsQuery->execute();

    if ($allShopsQuery->rowCount() > 0) {
        while ($row = $allShopsQuery->fetch()) {
            // Code to display the shop
            // Modify this part according to your needs
            echo '<div class=\'col-sm-4 col-md-4  mb-2\'>
                <div class=\'card\' >
                <form action="" method="POST">
                <img src=\'../shop_owner/layout/images/logo/'. $row['shop_Logo'] . '\' class=\'card-img-top\' alt=\'...\'>
                <div class=\'card-body\'>
                    <a href="shop_items.php?Shop_ID=' . $row['shopID'] . '">
                        <div class="d-flex align-items-center mb-4">
                            <img src="../shop_owner/layout/images/logo/'.$row['shop_Logo'].'" alt="Description of the image" class="rounded-circle" style="width: 35px;height: 35px;border: 1px solid black;">
                            <span class="ml-3">'. $row['shop_Name'].'</span>
                        </div>
                    </a>
                
                    <input type="hidden" name="shopID" value="'.$row['shopID'].'"> 

                    <div class="row p-0">
                        <div class="col-sm-12 mb-2">
                            <h6 style="font-weight: bold;">Shop category:</h6>
                            <h6 class="mb-0" style="font-weight: 400; color:#757D75;">';
            
                            // Fetch and display shop categories for each shop
                            $shopCategoriesQuery = $con->prepare("SELECT Category_ID FROM shop_category WHERE shopID = ?");
                            $shopCategoriesQuery->execute([$row['shopID']]);
                            $categoryCount = $shopCategoriesQuery->rowCount();
                            
                            if ($categoryCount > 0) {
                                $categories = $shopCategoriesQuery->fetchAll(PDO::FETCH_COLUMN);
                                foreach ($categories as $index => $categoryID) {
                                    $Category_name = getCategryName($categoryID);
                                    echo $Category_name;
                                    if ($index < $categoryCount - 1) {
                                        echo ', ';
                                    } else {
                                        echo '.';
                                    }
                                }
                            } else {
                                echo 'No category assigned.';
                            }

                    echo '</h6>
                        </div>
                        <div class="col-sm-12 mb-2">
                            <div class="form-group mb-2 d-flex">
                            </div>
                        </div>
                       
                        <a href=\'shop_items.php?Shop_ID='.$row['shopID'].'\' class=\'btn ml-3\'>Visit shop </a>
                    </div>
                </div>
            </form>                </div>
            </div>';
        }
    } else {
        echo '<div style="text-align: center; margin: 207px auto;"><h5>No shops found.</h5></div>';
    }
}

?>

<!--  -->


