<?php
session_start();
$pageTitle = "Edit item";

if (isset($_SESSION['shop_onwer_id']) && isset($_GET['itemID'])) {
      error_reporting(E_ERROR |E_PARSE);

      include("intil.php");  //<!-- router -->

      if (isset($_POST['submit-update-item'])) {
        include("connection.php");


                // Get data that comes from the form
                $item_id=$_GET['itemID'];

                // Retrieve the selected categories
                $selectedCategories = $_POST['Category'];
                $Category = implode(', ', $selectedCategories);

                // Retrieve the selected sub-categories
                $selectedSubCategories = $_POST['sub-Category'];
                if (empty($selectedSubCategories)) {
                  $subCategory = NULL;
                } else {
                  $subCategory = implode(', ', $selectedSubCategories);
                }


        $title = $_POST['title'];
        $item_sdsc = $_POST['sdsc'];
        $Price = trim($_POST['Price']);
        $quantity = $_POST['quantity'];
        $Discount = $_POST['Discount'];
                      // accessing image error
        // SQL statement
        if ($_FILES['img']['name'] != '') {

              $item_img_name = $_FILES['img']['name'];
              // accessing image name
              $item_img_tmp = $_FILES['img']['tmp_name']; // accessing image tmp_name
              $item_img_err = $_FILES['img']['error']; // accessing image error

            // 
              if ($item_img_err === 0) {
                if ($item_img_size > 2000000) {
                    $err = "Sorry, file size is too large.";
                    header("Location: Add_item.php?error=$err$item_img_size");
                } else {
                    // echo "<script>alert('All good Not more than 2MB')</script>";
                }
            
                $img_EXTENSION = pathinfo($item_img_name, PATHINFO_EXTENSION);
                $img_EXTENSION_lc = strtolower($img_EXTENSION);
                $allowed_img_EXTENSION = array("jpg", "jpeg", "png");
            
                if (in_array($img_EXTENSION_lc, $allowed_img_EXTENSION)) {
                  move_uploaded_file($item_img_tmp, "layout/images/items/$item_img_name");
                  $stat = $con->prepare("UPDATE item SET  Category_ID = ?, Sub_Category_ID = ?, Title = ?,Item_image=?, Item_description = ?, Price = ?, Quantity = ?, Discount_Percent = ? WHERE ItemID = ?");
                  $stat->execute(array($Category,$subCategory,$title,$item_img_name, $item_sdsc, $Price, $quantity, $Discount, $item_id));

                    if ($stat) {
                      echo "<script>alert('item has been updated successfully')</script>";
                      header("Location:items.php");  
                                      } else {
                        echo "<script>alert('error')</script>";

                    }
            
                    // insert now

                } else {
                    $err = "Sorry, file type is not allowed.";
                    header("Location: edit_item.php?error=$err$item_img_size");
                }
            } else {
                $err = "Unknown error occurred!";
                header("Location: edit_item.php?error=$err");
            }

        } else {
            // No new file uploaded for img , then keep the old file img data
            $stat = $con->prepare("UPDATE item SET  Category_ID = ?, Sub_Category_ID = ?, Title = ?, Item_description = ?, Price = ?, Quantity = ?, Discount_Percent = ? WHERE ItemID = ?");
            $stat->execute(array($Category,$subCategory,$title, $item_sdsc, $Price, $quantity, $Discount, $item_id));
            if ($stat) {
                // check item state if  > 0 update to Active 
                $stmt = $con->prepare("UPDATE item SET Item_state = 'Active' WHERE ItemID = :itemID AND Quantity > 0");
                $stmt->bindParam(':itemID', $item_id);
                $stmt->execute();

              echo "<script>alert('Item has been updated successfully')</script>";
              $_SESSION['show_message'] = true;
              header("Location: items.php");
          

            } else {
                echo "<script>alert('error')</script>";

            }
        }
    }

    ?>

<style>
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
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

.buttons_R a {
    background-color: #dc3545;
    color: white;
    padding: 6px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;

    border: 1px solid transparent;
    font-size: 16px;
    line-height: 1.5;
    border-radius: 0.25rem;
}
</style>

<?php
        // include functions
        include('includes/functions/getShopID.php');
        include('includes/functions/getCategryName.php');
        include('includes/functions/getSubCategryName.php');

        $ownerId = $_SESSION['shop_onwer_id'];
        $shopID = getShopID($ownerId);

        //  item selection
        $stat_3 = $con->prepare("select * from item where ItemID=? ");
        $stat_3->execute(array($_GET['itemID']));
        $row_3 = $stat_3->fetch();     // get Data from DB
        $count_3 = $stat_3->rowCount();    // count the number of rows

        if ($count_3 > 0) {
            $item_img = $row_3['Item_image'];
            $item_Title = $row_3['Title'];
            $item_description = $row_3['Item_description'];
            $item_Price = $row_3['Price'];
            $item_Quantity = $row_3['Quantity'];
            $item_Discount_Percent = $row_3['Discount_Percent'];
            $item_Category_ID = $row_3['Category_ID'];
            $item_Sub_Category_ID = $row_3['Sub_Category_ID'];


        } else {
            echo '<div style="text-align: center; margin: 207px auto;">NO such item in the database</div>';
        }
        //  end item selection
        //  catogey and sub-catogey selection 
        $stat = $con->prepare("SELECT * FROM shop_category WHERE shopID=? ");
        $stat->execute(array($shopID));

        $options = array(); // Array to store the options
        if ($stat->rowCount() > 0) {
            while ($row = $stat->fetch()) {
                $CategoryId = $row['Category_ID'];
                $Category_name = getCategryName($CategoryId, $shopID);
                $options[] = array('id' => $CategoryId, 'name' => $Category_name); // Store the option in the array
            }
        }

        // 
        $stat_2 = $con->prepare("SELECT * FROM category_subcategories WHERE Category_ID=? ");
        $stat_2->execute(array($item_Category_ID));

        $options_2 = array(); // Array to store the options
        if ($stat_2->rowCount() > 0) {
            while ($row = $stat_2->fetch()) {
                $subCategryId = $row['Sub_Category_ID'];
                $subCategory_name = getSubCategryName($subCategryId);
                $options_2[] = array('id' => $subCategryId, 'name' => $subCategory_name); // Store the option in the array
            }
        }


        // end catogey and sub-catogey selection 

      
    ?>


<section class="dashboard">
    <?php if(isset($_GET['error'])) ?><p><?php echo $_GET['error'];?> </p>

    <div class="container  mt-2 bg-white  " style="width:75%;     min-height: 1040px;">

        <div id="message"></div>

        <div class="row  justify-content-center mb-4 ">
            <h2 class="R-h2 p-3"> Edit item details</h2>
        </div>
        <form method="POST" id="edit-item-form" enctype="multipart/form-data">

            <!-- update POP UP FORM (Bootstrap MODAL) -->
            <div class="modal fade" id="updatemodal-item" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Update account information </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <div class="modal-body">

                            <!-- <input type="hidden" name="delete_id" id="delete_id"> -->

                            <h4 style="display: flex;
                                                justify-content: center;
                                                align-items: center;">
                                Are you sure you want to update account information?
                            </h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn " style="backgroud-color:red;background-color: red;"
                                data-dismiss="modal"> NO </button>
                            <button name="submit-update-item" class="btn " type="submit">Update <i
                                    class="fa-light fa-badge-check"></i></button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- end -->
            <div class="text-center">
                <img src="layout/images/items/<?php echo $item_img ?> " class="avatar img-circle img-thumbnail"
                    style="height: 240px;" alt="avatar">
                <h6>Upload a different image...</h6>
                <input type="file" name="img" class="text-center center-block file-upload" id="img" onchange="checkfileimg()">
                <div class="input-group">
                <span id="img-err" style="margin-right: 150px;"></span>
                </div> 
                </div> 
                   

                </hr><br>


                <?php
          
                 ?>
                <!-- catogey and sub-catogey-->
                <div class="frmDronpDown mt-3">
                    <div class="form-row">
                        <div class="col-sm-6">
                            <label for="catogry-list">Category:</label>
                            <select name="Category[]" class="form-control list-options" id="catogry-list"
                                onChange="getSubCaetogry();" multiple size="4" onchange="validateCategories()">
                                <?php
                                        foreach ($options as $option) {
                                            if ($option['id'] == $item_Category_ID) { ?>
                                <option value="<?php echo $option['id']; ?>" selected><?php echo $option['name']; ?>
                                </option>
                                <?php } else { ?>
                                <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                                <?php }
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-valid"> <span id="sub-category-err"> </span></div>

                            <label for="sub-Category-list">Sub-Category:</label>
                            <select name="sub-Category[]" class="form-control list-options" id="sub-Category-list"
                                style="height: 111px;" multiple size="5" onchange="validateSubCategories()">
                                <?php
                                        foreach ($options_2 as $option) {
                                            if ($option['id'] == $item_Sub_Category_ID) { ?>
                                <option value="<?php echo $option['id']; ?>" selected><?php echo $option['name']; ?>
                                </option>
                                <?php } else { ?>
                                <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                                <?php }
                                        }
                                        ?>
                            </select>
                        </div>
                    </div>
                </div>



                <!-- end -->

                <div class="form-row mt-3">
                    <div class=" col-sm-12 ">
                        <label for="inputEmail4">item name </label>
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="Enter item title"
                                id="input-title" onkeyup="validateTitle()" value=" <?php echo $item_Title ?>">
                            <span id="title-err"> </span>
                        </div>
                    </div>

                </div>

                <div class="form-row mt-3">
                    <div class="col-sm-12 ">
                        <label for="inputPassword4">item description</label>
                        <div class="input-group">
                            <textarea class="form-control" name='sdsc' rows="4" placeholder="Enter item description "
                                id="item-dsc" onkeyup="validatedsc()"><?php echo$item_description ?></textarea>
                            <span id="Item_description-err"></span>
                        </div>
                    </div>
                </div>


                <div class="form-row mt-3">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Price </label>
                        <div class="input-group">
                            <input type="text" name="Price" class="form-control" placeholder="Enter item price"
                                id="Price" onkeyup="validatePrice()" value="<?php echo $item_Price ?>">
                            <span id="Price-err"> </span>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Quantity </label>
                        <div class="input-group">

                            <input type="number" name="quantity" class="form-control" id="Qun" min="1"
                                onkeyup="validateQun()" value="<?php echo $item_Quantity; ?>">

                            <span id="Qun-err"> </span>
                        </div>

                    </div>
                </div>



                <div class="form-row mt-3">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Discount percent</label>
                        <div class="input-group">
                            <input type="number" name="Discount" class="form-control" id="discount" min="0"
                                onkeyup="validatediscount()" value="<?php echo$item_Discount_Percent; ?>">

                            <span id="discount-err"></span>
                        </div>
                    </div>


                </div>

                <!--  -->
                <div class="d-flex justify-content-center">
                    <div class="buttons_R mt-5 " style="
                display: inline-flex;">
                        <a href="items.php" class="ml-2 mr-2">Cancel</a>

                        <button type="button" name="ADD_New_item" class="btn mx-auto d-block mr-2 updatebtn-item"
                            id="submitbtnitemUpdate">Update</button>
                    </div>

                </div>

            </div>



        </form>

    </div>


</section>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {

    $('.updatebtn-item').on('click', function() {
        event.preventDefault(); // Prevent the default form submission

        $('#updatemodal').modal('show');


    });
});

// start getSubCaetogry

function getSubCaetogry() {
    var categoryId = document.getElementById("catogry-list").value; // Get the selected category ID

    // Make an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getSubCategories.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("sub-Category-list").innerHTML = xhr
                .responseText; // Update the sub-category options
        }
    };
    xhr.send("categoryId=" + categoryId); // Send the selected category ID to the PHP script
}

// END
</script>

<?php
    include($tmpl . 'footer.php'); //<!-- footer -->
} else {
    echo "You are not authorized to enter this page";
    header('location:../Users/index.php');
}
?>