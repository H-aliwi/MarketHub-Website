<?php
session_start();
$pageTitle = "Shops page";
if (isset($_SESSION['usernameA'])) {
    
        include("intil.php");
        include('includes/functions/getCategryName.php'); 
        include("connection.php");
        $stat = $con->prepare("SELECT * FROM shop s , Shop_Owner so
        WHERE s.Shop_OwnerID =so.Shop_OwnerID  and so.Shop_owner_state ='Active';");
        $stat->execute();

        $categoriesQuery = $con->prepare("SELECT * FROM category");
        $categoriesQuery->execute();




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
        height: 140px;
        object-fit: contain;
        padding: 2px;
    }

    .card-flex {
        position: relative;
    }
 
    </style>
    <div class="container">
    <div class="card-flex d-flex align-items-center justify-content-center mt-3 mb-3" style="background-color: #192a51; color: white;">
    <div class="row mx-0">
      <div class="col">
        <h2 class="card-title">Shops</h2>
      </div>
    </div>
  </div>
        
        <div class="row ">
            <div class="col-md-10">
                <div class="row" id="result" style="min-height: 550px;">
                    <?php
                    if ($stat->rowCount() > 0) {
                        while ($row = $stat->fetch()) {
                            $stat_2 = $con->prepare("SELECT sc.Category_ID FROM shop_category sc WHERE sc.shopID = ?");
                            $stat_2->execute(array($row['shopID']));
                    
                            $categories = array(); // Create an empty array to store the fetched categories
                    
                            while ($categoryRow = $stat_2->fetch()) {
                                $categories[] = $categoryRow['Category_ID']; // Append the fetched category ID to the categories array
                            }
                    
                            echo '  <div class=\'col-sm-4 col-md-4  mb-2\'>
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
                                                        <h6 class="mb-0" style="font-weight: 400; color:#757D75;"> ';
                                                        $categoryCount = count($categories);
                                                        foreach ($categories as $index => $categoryID) {
                                                            $CategryId = $categoryID;
                                                            $Category_name = getCategryName($CategryId);
                                                            echo $Category_name;
                                                            if ($index < $categoryCount - 1) {
                                                                echo ', ';
                                                            } else {
                                                                echo '.';
                                                            }
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
                                        </form>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo '<div style="text-align: center; margin: 207px auto;"> <h5>  No shops yet.</h5></div>';
                    }
                    ?>
                </div>

            </div>
            <div class="col-md-2 bg-secondary p-0">
                <div class="sidebar-shop"> 

                    <ul class="navbar-nav me-auto text-center" style="list-style-type: none;">
                        <li style="background-color: #192a51;" class="vab-item">
                            <h4 style="color: aliceblue;">Filter</h4>
                        </li>
                        <?php
                if ($categoriesQuery->rowCount() > 0) {
                    while ($categoryRow = $categoriesQuery->fetch()) {
                        echo '<li class="p-1" style="text-align: left;">
                                <input type="checkbox" id="category_'.$categoryRow['Category_ID'].'" class="category-checkbox" name="categories[]" value="'.$categoryRow['Category_ID'].'">
                                <label for="category_'.$categoryRow['Category_ID'].'" style="color: azure; font-size:16px;">'.$categoryRow['Category_name'].'</label>
                            </li>';
                    }
                } else {
                    echo '<p>No categories found.</p>';
                }
                ?>
                    </ul>
                </div>
            </div>



        </div>

    </div>


    </div>


    <!-- <section name="footer">
        <div class=" p-3  text-center" style="  background-color: #192a51; ">
            <p style=" color: aliceblue;">&copy; 2023 BSE Shop. All rights reserved. | Desigend by Hussain Aliwi</p>
        </div>
    </section> -->

    <?php
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Event listener for category checkboxes
        $('.category-checkbox').on('change', function() {
            var selectedCategories = [];
            $('.category-checkbox:checked').each(function() {
                selectedCategories.push($(this).val());
            });

            // Make AJAX request to retrieve shops based on selected categories
            $.ajax({
                url: 'get_shops.php',
                method: 'POST',
                data: {
                    categories: selectedCategories
                },
                success: function(response) {
                    // Replace the shop section with the updated content
                    $('#result').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log(error);
                }
            });
        });
    });
    </script>




    <?php include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>