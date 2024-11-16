<?php 
session_start();
require("connection.php");

if (isset($_POST['Save'])) {
    // Retrieve the form data
    $SCId = $_POST['SCTId'];
    $SCatName = $_POST['SCatN'];
    $SCatDesc = $_POST['SCatDes'];

    // Process the new data
    $stmnt1 = $db->prepare("UPDATE sub_category SET Sub_Category_name = :SCatName, Sub_Category_description = :SCatDesc WHERE Sub_Category_ID = :SCId");
    $stmnt1->bindParam(':SCatName', $SCatName);
    $stmnt1->bindParam(':SCatDesc', $SCatDesc);
    $stmnt1->bindParam(':SCId', $SCId);
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
if (isset($_GET['subcatID'])) {
    
            include("intil.php");

            $SubCatID = $_GET['subcatID'];
            $stmnt = $db->prepare("SELECT * FROM sub_category WHERE Sub_Category_ID = :SubcatID");
            $stmnt->bindParam(':SubcatID', $SubCatID);
            $stmnt->execute();
            $SubCategory = $stmnt->fetch();

            if ($SubCategory) {
        ?>
        <section class="dashboard">

        <h1> Edit Sub-Category</h1>

        <hr>

        <form method="post" class="mt-5">

        <input type="hidden" name="SCTId" value="<?php echo $SubCatID ?>">

            <div class="form-group">
                <label for="SCatN"><b> Sub-Category Name </b></label>
                <input type="text" class="form-control" name="SCatN" id="SCatN" value="<?php echo $SubCategory['Sub_Category_name']; ?>">
            </div>
            <div class="form-group">
                <label for="SCatDes"><b> Sub-Category Description </b></label>
                <textarea type="textera" class="form-control" name="SCatDes" id="SCatDes" rows="5"><?php echo $SubCategory['Sub_Category_description']; ?></textarea>
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
