<?php 
session_start();
require("connection.php");

if (isset($_POST['Save'])) {
    // Retrieve the form data
    $CId = $_POST['CTId'];
    $catName = $_POST['CatN'];
    $catDesc = $_POST['CatDes'];
    $itemImage = $_FILES['img']['name'];
    $item_img_tmp = $_FILES['img']['tmp_name'];


    // Process the new data
    $stmnt1 = $db->prepare("UPDATE category SET Category_name = :catName, Category_description = :catDesc, Category_image = :img WHERE Category_ID = :catID");
    $stmnt1->bindParam(':catName', $catName);
    $stmnt1->bindParam(':catDesc', $catDesc);
    $stmnt1->bindParam(':img', $itemImage);

    $stmnt1->bindParam(':catID', $CId);
    $stmnt1->execute();


    if ($stmnt1-> rowCount() > 0) {
        move_uploaded_file($item_img_tmp, "../shop_owner/layout/images/catogry/$itemImage");

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
if (isset($_GET['catID'])) {
    
            include("intil.php");

            $catID = $_GET['catID'];
            $stmnt = $db->prepare("SELECT * FROM category WHERE Category_ID = :catID");
            $stmnt->bindParam(':catID', $catID);
            $stmnt->execute();
            $category = $stmnt->fetch();

            if ($category) {
        ?>
        <section class="dashboard">

        <h1> Edit Category</h1>

        <hr>

        <form method="post" class="mt-5"  enctype="multipart/form-data">

        <input type="hidden" name="CTId" value="<?php echo $catID ?>">
            <div class="mx-auto" style="
                                        display: flex;
                                        flex-direction: column;
                                        flex-wrap: wrap;
                                        justify-content: center;
                                        align-items: center;
                                    ">
            <img src="../shop_owner/layout/images/catogry/<?php echo $category['Category_image'] ?> " class="avatar img-circle img-thumbnail"
                                style="height: 240px; width:400px" alt="avatar">
                            <h6>Upload a different image...</h6>
                            <input type="file" name="img" class="text-center center-block file-upload" id="img" onchange="checkfileimg()">
                            <div class="input-group">
                            <span id="img-err" style="margin-right: 150px;"></span>
                            </div> 
            </div>


            <div class="form-group">
                <label for="CatN"><b> Category Name </b></label>
                <input type="text" class="form-control" name="CatN" id="CatN" value="<?php echo $category['Category_name']; ?>">
            </div>
            <div class="form-group">
                <label for="CatDes"><b> Category Description </b></label>
                <textarea type="textera" class="form-control" name="CatDes" id="CatDes" rows="5"><?php echo $category['Category_description']; ?></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="CatPho"><b> Uplode new photo </b></label>
                <input type="file" class="form-control-file" name="CatPho" id="CatPho">
            </div> -->
            <a href="categories.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="Save" class="btn btn-primary">Save Changes</button>
        </form>
            

        </section>


        <?php                
            
        }
            include($tmpl . 'footer.php'); //<!-- footer -->
    }

?>
