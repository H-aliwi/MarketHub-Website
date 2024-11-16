<?php 
session_start();
require("connection.php");
include("intil.php");

if (isset($_POST['Add'])) {
    // Retrieve the form data
    $subCatName = $_POST['SCatN'];
    $subCatDesc = $_POST['SCatDes'];

    // Process the new data
    $stmnt1 = $db->prepare("INSERT INTO sub_category (Sub_Category_name, Sub_Category_description) VALUES (:subCatName, :subCatDesc)");
    $stmnt1->bindParam(':subCatName', $subCatName);
    $stmnt1->bindParam(':subCatDesc', $subCatDesc);
    $stmnt1->execute();

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

        <h1> Add new Sub Category</h1>

        <hr>

        <form method="post" class="mt-5">

            <div class="form-group">
                <label for="SCatN"><b> Sub Category Name </b></label>
                <input type="text" class="form-control" name="SCatN" id="SCatN" Placeholder="Enter the sub category name">
            </div>
            <div class="form-group">
                <label for="SCatDes"><b> Sub Category Description </b></label>
                <textarea type="textera" class="form-control" name="SCatDes" id="SCatDes" rows="5" Placeholder="Write the sub category description"></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="CatPho"><b> Uplode new photo </b></label>
                <input type="file" class="form-control-file" name="CatPho" id="CatPho">
            </div> -->
            <a href="categories.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="Add" class="btn btn-primary">Add Sub-Category</button>
        </form>
            

        </section>


<?php                 
    include($tmpl . 'footer.php'); //<!-- footer -->
?>