<?php 

session_start();
if (isset($_SESSION['shop_onwer_id'])) {
    $pageTitle = "Add new item";

include("intil.php");  //<!-- router -->
include('includes/functions/getShopID.php');
include('includes/functions/getCategryName.php');
$pageTitle = "Add new item";

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

.list-options {
    padding: 5px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: auto;
    max-height: 320px;
}
</style>

<?php
    include("connection.php");
    error_reporting(E_ERROR |E_PARSE);

    $ownerId = $_SESSION['shop_onwer_id'];
    $shopID = getShopID($ownerId);
    $stat = $con->prepare("SELECT * FROM shop_category WHERE shopID=? ");
    $stat->execute(array($shopID));

    
    ?>
<section class="dashboard ">

    <?php if(isset($_GET['error'])) ?><p><?php echo $_GET['error'];?> </p>

    <section class="Add_item">

        <div class="container  mt-3 bg-white  " style="width:70%;     min-height: 775px;min-width:370px;">
        <div id="message"style="width:100%;"></div>

            <div class="row  justify-content-center mb-4 ">
                <h2 class="R-h2 p-3"> Add new item</h2>
            </div>
            <form method="POST" id="item-form" enctype="multipart/form-data" >
                        <?php
                $options = array(); // Array to store the options
                if ($stat->rowCount() > 0) {
                    while ($row = $stat->fetch()) {
                        $CategoryId = $row['Category_ID'];
                        $Category_name = getCategryName($CategoryId, $shopID);
                        $options[] = array('id' => $CategoryId, 'name' => $Category_name); // Store the option in the array
                    }
                }
                ?>
                        <div class="frmDronpDown">
                            <div class="form-row">
                                <div class="col-sm-6">

                                    <lable for="catogry-list">Category:</lable>
                                    <div class="input-valid"><span id="category-err"></span></div>
                                    <select name="Category[]" class="form-control list-options" id="catogry-list"
                                        onChange="getSubCaetogry();" multiple size="4">

                                        <?php
                                foreach ($options as $option) {
                                    ?>
                                        <option value="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></option>
                                        <?php
                                }
                                ?>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <lable for="sub-Category-list">Sub-Category:</lable>
                                    <div class="input-valid"><span id="sub-category-err" style="margin-left: 131px; margin-top: -20px;"></span></div>
                                    <select name="sub-Category[]" class="form-control list-options" id="sub-Category-list"
                                        style="height: 111px;" multiple size="5">
                                        <option value="">Select Sub-Category</option>

                                    </select>


                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class=" col-sm-12 ">
                                <lable for="inputTitel">item name </lable>
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control" placeholder="Enter item title" id="input-title">
                                    <span id="title-err"> </span>
                                </div>
                            </div>

                        </div>

                        <div class="form-row mt-3">
                            <div class="col-sm-12 ">
                                <lable for="inputdsc">item description</lable>
                                <div class="input-group">
                                    <textarea class="form-control" name='sdsc' rows="4" id="item-dsc" placeholder="Enter item description "
                                        id="input-description_shop"></textarea>
                                    <span id="Item_description-err"></span>
                                </div>
                            </div>
                        </div>


                        <div class="form-row mt-3">
                            <div class="form-group col-md-6">
                                <lable for="inputprice">Price </lable>
                                <div class="input-group">
                                    <input type="text" name="Price" class="form-control" placeholder="Enter item price" id="Price">
                                    <span id="Price-err"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <lable for="inputQUN">Quantity </lable>
                                <div class="input-group">
                                    <input type="number" name="quntitiy" class="form-control"  min="1" value="1" ;
                                        placeholder="Enter item qunitity" id="Qun" >
                                    <span id="Qun-err"></span>
                                </div>

                            </div>
                        </div>



                        <div class="form-row mt-3">
                            <div class="form-group col-md-6">
                                <lable for="inputDS">Discount percent</lable>
                                <div class="input-group">
                                    <input type="number" name="Discount" class="form-control" id="discount" min="0" value="0"
                                        placeholder="Enter item  Discount %" >
                                    <span id="discount-err"></span>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <lable for="inputIMG">item image</lable>
                                <div class="input-group">
                                    <input type="file" name="img" placeholder="Enter your Password" id="img"
                                        >
                                    <span id="img-err" style="margin-top: 28px;"></span>
                                </div>
                            </div>
                        </div>

                        <!--  -->



                        <button type="submit" name="ADD_New_item" class="btn  mx-auto d-block mt-2 " id="submitbtn">ADD</button>


                </div>


    </form>

        </div>

    </section>
</section>

<!--  -->







<!--  -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {


    $('select[name="Category[]').on('input', function () {
        validateCategories();
    });
    $('select[name="sub-Category[]').on('input', function () {
        validateSubCategories();
    });
    $('#input-title').on('input', function () {
        validateTitle();
    });
    $('#item-dsc').on('input', function () {
        validatedsc();
    });

    $('#Price').on('input', function () {
        validatePrice();
    });
    $('#Qun').on('input', function () {
        validateQun();
    });
    $('#discount').on('input', function () {
        validatediscount();

    });

    $('#img').on('input', function() {
        checkfileimg();
    });
    
        


    $('#submitbtn').click(function(e) {
        e.preventDefault();

        var isValid = true;

        // Perform your validation checks here
        if ( !validateCategories() ||  !validateSubCategories() ||!validateTitle() || !validatedsc() || !validatePrice() || !validateQun() || !checkfileimg() ) {
            isValid = false;
            
            $("#message").html(`<div class="alert alert-warning" style="margin: 0px -16px;">Please fill all required fields</div>`);
            console.log("Validation error");
            window.scrollTo({
            top: 0,
            behavior: 'smooth'
                            });
        }

        if (isValid) {
            console.log("Validation successful");
            $("#message").html("");
            var form = $('#item-form')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "add_item_prosses.php",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#message').html(data);
                    var message = "Data successfully inserted";
                    window.location.href = "items.php?message=" + encodeURIComponent(message);

                },
                error: function () {
                    console.log("Error submitting form");
                    $("#message").html("<div class='alert alert-danger'>Error submitting form</div>");
                }
            });
        }
    });
});


    // Function to validate the category selection
    function validateCategories() {
        var selectedCategories = $('select[name="Category[]"]').val();
        if (!selectedCategories || selectedCategories.length === 0) {
            $("#category-err").html("*Please select item category");
            return false;
        } else {
            $("#category-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;
        }
    }

        // Function to validate the sub-category selection
        function validateSubCategories() {
        var selectedSubCategories = $('select[name="sub-Category[]"]').val();
        if (!selectedSubCategories|| selectedSubCategories.length === 0) {
            $("#sub-category-err").html("*Please select sub category");
            return false;
        } else {
            $("#sub-category-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;
        }
    }

        // Function to validate the item titel 
        function validateTitle() {
            var title = $('#input-title').val();
            if(title.length == 0){
                $('#title-err').html('*title is required');
                    return false;

            }
                else if(!title.match (/^(?=(?:.*[a-zA-Z]){4})[a-zA-Z\d\s|()~-]{10,}$/)){
                $('#title-err').html('*must contain 10 letters ');

                    return false;
                    
                }
                else if(!title.match (/^(?=(?:.*[a-zA-Z]){4})[a-zA-Z\d\s|()~-]{10,60}$/)){
                $('#title-err').html('*maximum 60 letters.');

                    return false;

                    
                }
                else
                {
                    $("#title-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                     return true;
                }
    }
            // Function to validate the item dsc
            function validatedsc() {
            var title = $('#item-dsc').val();
            if(title.length == 0){
                $('#Item_description-err').html('*description is required');
                    return false;

            }
                else if(!title.match (/^(?=(?:.*[a-zA-Z]){10})[a-zA-Z\d\s.|\\#()%.,\"*{}[\]:\/><+\-]{10,}$/)){
                $('#Item_description-err').html('*must contain 10 letters.');

                    return false;
                }
                else
                {
                    $("#Item_description-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                     return true;
                }
    }  
    // END 
    function validatePrice() {
            var Price = $('#Price').val();
            if(Price.length == 0){
                $('#Price-err').html('*Price is required');
                    return false;

            }
                else if(!Price.match (/^(?:[0-9]{1}\.[1-9]\d{2}|[0-9]{2}\.[0-9]{3}|[1-9]\d{0,2}(?:\.\d{3})?)$/
)){
                $('#Price-err').html('*must be >= 0.100');

                    return false;
                }
                else
                {
                    $("#Price-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                     return true;
                }
    }      // END 

    function validateQun() {
            var Qun = $('#Qun').val();
            if(Qun.length == 0){
                $('#Qun-err').html('*Price is required');
                    return false;

            }
                else if(!Qun.match (/^([1-9]|[1-9]\d|1\d{2}|200)$/)){
                $('#Qun-err').html('*must be number 1-200');

                    return false;
                }
                else
                {
                    $("#Qun-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                     return true;
                }
    }      // END 

    function validatediscount() {
            var discount = $('#discount').val();
            if(discount.length == 0){
                $('#discount-err').html('*discount percent is required');
                    return false;

            }
                else if(!discount.match (/^(?:\d|[1-9]\d|100)$/)){
                $('#discount-err').html('*must be number 0-100');

                    return false;
                }
                else
                {
                    $("#discount-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                     return true;
                }
    }      // END 

    function checkfileimg() {
    var fileInput = $('#img')[0];
    var file = fileInput.files[0];

    if (!file) {
        $('#img-err').html('* item image is required');
        return false;
    }

    // Check file type
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
        $('#img-err').html('*Only JPEG, PNG, and JPG images are allowed');
        return false;
    }

    // Check file size
    var maxSize = 10 * 1024 * 1024; // 10 MB
    if (file.size > maxSize) {
        $('#img-err').html('*image size should be less than 10 MB');
        return false;
    }



    $('#img-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
    return true;
}
// END img

    
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

// end getSubCaetogry
</script>
</body>

</html>
<?php

} else {
    echo "You are not authorized to enter this page";
    header('location:../Users/index.php'); 
}
?>