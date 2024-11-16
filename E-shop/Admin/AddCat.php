<?php 
session_start();
require("connection.php");
include("intil.php");


if (isset($_POST['Add'])) {
    // Retrieve the form data
    $catName = $_POST['CatN'];
    $catDesc = $_POST['CatDes'];
    // img 
    $itemImage = $_FILES['img']['name'];
    $item_img_tmp = $_FILES['img']['tmp_name'];

    // Process the new data
    $stmnt1 = $db->prepare("INSERT INTO category (Category_name, Category_description,Category_image) VALUES (:catName, :catDesc ,:catimg)");
    $stmnt1->bindParam(':catName', $catName);
    $stmnt1->bindParam(':catDesc', $catDesc);
    $stmnt1->bindParam(':catimg', $itemImage);
    $stmnt1->execute();
    move_uploaded_file($item_img_tmp, "../shop_owner/layout/images/catogry/$itemImage");

    if ($stmnt1-> rowCount() > 0) {

        // Redirect to the Category page
        header("Location: categories.php");
        exit;
    } 
    else {
        ?>
            <script>
                alert("There is a problem with your data. Please check them again.");
            </script>

            <?php
    }
}

?>


<section class="dashboard">

        <h1> Add new Category</h1>

        <hr>

        <form method="post" class="mt-5" enctype="multipart/form-data">
             <div class="form-group ">
             <label for="CatN"><b> Category image</b></label>

                <div class="input-group">
                 <input type="file" name="img" placeholder="Enter your Password" id="img" >
                 <span id="img-err" style="margin-top: 28px;"></span>
                </div>
             </div>
 
            <div class="form-group">
                <label for="CatN"><b> Category Name </b></label>
                <input type="text" class="form-control" name="CatN" id="CatN" Placeholder="Enter the category name">
            </div>
            <div class="form-group">
                <label for="CatDes"><b> Category Description </b></label>
                <textarea type="textera" class="form-control" name="CatDes" id="CatDes" rows="5" Placeholder="Write the category description"></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="CatPho"><b> Uplode new photo </b></label>
                <input type="file" class="form-control-file" name="CatPho" id="CatPho">
            </div> -->
            <a href="categories.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="Add" class="btn btn-primary">Add Category</button>
        </form>
            

        </section>


<?php                 
    include($tmpl . 'footer.php'); //<!-- footer -->
?>