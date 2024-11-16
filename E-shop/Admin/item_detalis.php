<?php
session_start();
if (isset($_GET['itemID'])) {
      error_reporting(E_ERROR |E_PARSE);

      include("intil.php");  //<!-- router -->


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
        include('includes/functions/getCategryName.php');
        include('includes/functions/getSubCategryName.php');


        //  item selection
        $stat_3 = $db->prepare("select * from item where ItemID=? ");
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

            $CategryId=$row_3['Category_ID'];
            $item_Category_ID=getCategryName($CategryId);

            $subCategryId=$row_3['Sub_Category_ID'];
            $item_Sub_Category_ID =getSubCategryName($subCategryId);


        } else {
            echo '<div style="text-align: center; margin: 207px auto;">NO such item in the database</div>';
        }

    ?>

<style>
/* Additional styles here */
</style>

<section class="dashboard">
    <?php if(isset($_GET['error'])) ?><p><?php echo $_GET['error'];?> </p>

    <div class="container  mt-2 bg-white  " style="width:75%;     min-height: 1040px;">

        <div id="message"></div>

        <div class="row  justify-content-center mb-4 ">
            <h2 class="R-h2 p-3">Item details</h2>
        </div>
        <form method="POST" id="edit-item-form" enctype="multipart/form-data">

            
            <div class="text-center">
                <img src="../shop_owner/layout/images/items/<?php echo $item_img ?> " class="avatar img-circle img-thumbnail"
                    style="height: 240px;" alt="avatar">
                
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
                            <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="Enter item title"
                                id="input-title"  value=" <?php echo $item_Category_ID ?>" disabled>
                            <span id="title-err"> </span>
                        </div>
                      
                        </div>
                        <div class="col-sm-6">
                            <div class="input-valid"> <span id="sub-category-err"> </span></div>
                            <label for="sub-Category-list">Sub-Category:</label>
                            <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="Enter item title"
                                id="input-title"  value=" <?php echo $item_Sub_Category_ID ?>" disabled>
                            <span id="title-err"> </span>
                        </div>
                      
                        
                        </div>
                    </div>
                </div>



                <!-- end -->

                <div class="form-row mt-3">
                    <div class=" col-sm-12 ">
                        <label for="inputEmail4">item title </label>
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="Enter item title"
                                id="input-title"  value=" <?php echo $item_Title ?>" disabled>
                            <span id="title-err"> </span>
                        </div>
                    </div>

                </div>

                <div class="form-row mt-3">
                    <div class="col-sm-12 ">
                        <label for="inputPassword4">item description</label>
                        <div class="input-group">
                            <textarea class="form-control" name='sdsc' rows="4" placeholder="Enter item description "
                                id="item-dsc" disabled><?php echo$item_description ?> </textarea >
                            <span id="Item_description-err"></span>
                        </div>
                    </div>
                </div>


                <div class="form-row mt-3">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Price </label>
                        <div class="input-group">
                            <input type="text" name="Price" class="form-control" placeholder="Enter item price"
                                id="Price" value=" <?php echo $item_Price ?>" disabled>
                            <span id="Price-err"> </span>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Qunitity </label>
                        <div class="input-group">

                            <input type="number" name="quantity" class="form-control" id="Qun" min="1"
                                value="<?php echo $item_Quantity; ?>" disabled>

                            <span id="Qun-err"> </span>
                        </div>

                    </div>
                </div>



                <div class="form-row mt-3">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Discount percent</label>
                        <div class="input-group">
                            <input type="number" name="Discount" class="form-control" id="discount" min="0"
                                value="<?php echo$item_Discount_Percent; ?>" disabled>

                            <span id="discount-err"></span>
                        </div>
                    </div>


                </div>



            </div>



        </form>

    </div>


</section>





<?php
    include($tmpl . 'footer.php'); //<!-- footer -->
} else {
    echo "You are not authorized to enter this page";
    header('location:../Users/index.php');
}
?>