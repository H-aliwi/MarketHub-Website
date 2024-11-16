<?php 

session_start();
if (isset($_SESSION['shop_onwer_id']) ) 
{     $pageTitle = "Shop Profile";
  
 include('includes/functions/getShopID.php');
 include('includes/functions/getCategryName.php');

 $ownerId = $_SESSION['shop_onwer_id'];
 $shopID = getShopID($ownerId);
 include("connection.php");


    if (isset($_POST['submitUP'])) {

        // Get data that comes from the form
        // shop owner info
        $email = $_POST['email'];
        $user = $_POST['user'];
        $shopOwnerID = $_SESSION['shop_onwer_id'];


        $stat = $con->prepare("UPDATE shop_owner SET Username = ?, Email =? WHERE Shop_OwnerID = ?");
        $stat->execute(array($user,$email,$shopOwnerID));


        // shop info
        $sname = $_POST['sname'];
        $paymentinfo = $_POST['pdscr'];
        $sDscription = $_POST['shopDsc'];

        if ($_FILES['img']['name'] != '') {
            $item_img_name = $_FILES['img']['name'];
            // accessing image name
            $item_img_tmp = $_FILES['img']['tmp_name']; // accessing image tmp_name
            $item_img_err = $_FILES['img']['error']; // accessing image error
        
            // SQL statement with now shop img
            $stat = $con->prepare("UPDATE shop SET shop_Name = ?, shop_Logo=?,shop_Description = ?, payment_Information = ?WHERE shopID = ?");
                 $stat->execute(array($sname,$item_img_name,$sDscription,$paymentinfo,$shopID));

        
            if ($stat->rowCount() > 0) {
                move_uploaded_file($item_img_tmp, "layout/images/logo/$item_img_name");
                echo "<script>alert('Account information has been updated successfully with.')</script>";
            }
        } else {
            // No new file uploaded, keep the old file data
            $stat = $con->prepare("UPDATE shop SET shop_Name = ?, shop_Description = ?, payment_Information = ?WHERE shopID = ?");
            $stat->execute(array($sname,$sDscription,$paymentinfo,$shopID));
            echo "<script>alert('Account information has been updated successfully without.')</script>";
        }



    }
    // end update
include("intil.php");  //<!-- router -->



$stat = $con->prepare("select * from shop_owner where Shop_OwnerID =? ");
$stat->execute(array($_SESSION['shop_onwer_id']));
$rows = $stat->fetch();  // get all rows of data from DB
$count = $stat->rowCount();  // count the number of rows
if($count >0){
    $Username=$rows['Username'];
    $Email=$rows['Email'];

}

$stat_2 = $con->prepare("select * from shop where Shop_OwnerID =? ");
$stat_2->execute(array($_SESSION['shop_onwer_id']));
$rows = $stat_2->fetch();  // get all rows of data from DB
$count_2 = $stat_2->rowCount();  // count the number of rows
if($count_2 >0){
    $shop_Name=$rows['shop_Name'];
    $shop_Description=$rows['shop_Description'];
    $payment_Information=$rows['payment_Information'];
    $shop_Logo=$rows['shop_Logo'];

}
$ownerId = $_SESSION['shop_onwer_id'];
$shopID = getShopID($ownerId);

$stat_3 = $con->prepare("select * from shop_category where shopID =?");
$stat_3->execute(array($shopID));
$rows = $stat_3->fetchAll(PDO::FETCH_ASSOC);// get all rows of data from DB





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

.list-group-item.active {
    z-index: 2;
    color: #000;
    background-color: #Eaeaea;
    border-color: #Eaeaea;
}
</style>
<section class="dashboard ">

    <form  method="POST" id="shop-formUP" enctype="multipart/form-data">
        <div class="container bootstrap snippet   mb-3 bg-white " style="height: 850px;">
        <div id="message-up"></div>

            <h2 class=" mb-4 mt-4  p-3 font-weight-bold text-center">shop owner profile</h2>



            <!-- update POP UP FORM (Bootstrap MODAL) -->
            <div class="modal fade" id="updatemodalShop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Update account information </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <div class="modal-body">

                            <input type="hidden" name="delete_id" id="delete_id">

                            <h4 style="display: flex;
                                            justify-content: center;
                                            align-items: center;">
                                Are you sure you want to update account information?
                            </h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn " style="backgroud-color:red;background-color: red;"
                                data-dismiss="modal"> NO </button>
                            <button name="submitUP" class="btn " type="submit">Update <i
                                    class="fa-light fa-badge-check"></i></button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- modal end -->


            <div class="row mt-2 ">
                <div class="col-sm-3 mt-4 ">
                    <!--left col-->
                    <!-- logo -->
                    <div class="text-center">

                        <!--  -->
                        <img src="layout/images/logo/<?php echo $shop_Logo ?>  " class="avatar img-circle img-thumbnail"
                            style="border-radius: 50%;" alt="avatar">
                            <div class="input-group">
                            <span id="logo-Err" style="margin-top: -310px;"> </span></div>
                        <h6>Upload a different shop logo...</h6>
                        <input type="file" name="img"  id="uplogo" class="text-center center-block file-upload" onchange="checkfileLogoup()">
                    </div>

                   
                    </hr><br>

                    <!--Trade rejester  -->
                    <div class="mt-3 mb-5">
                        <div class="panel-heading">Trade rejester</div>
                        <div class="panel-body">
                            <div class="input-group">
                                <input type="file" name='trade' placeholder="Enter your Password" id="upTrade"
                                    onchange="validateTradeup()">
                                <span id="Trade-Err" style="margin-top: 30px;"></span>
                            </div>


                            <div class="list-group mt-4  mb-4 w-70" >
                                <div class="list-group-item list-group-item-action active" style="margin-top: 50px;">Shop categories:</div>

                                <?php   
            if($stat_3->rowCount() >0){            
                foreach ($rows as $row) {
                    $CategryId=$row['Category_ID'];
                    $CategryName=getCategryName($CategryId);
                    echo' <div  class="list-group-item list-group-item-action">'.$CategryName.'</div>';

                 
                }
              
            }
            ?>

                            </div>
                        </div>
                    </div>

                </div>
                <!--/col-3-->
                <div class="col-sm-9 ">



                    <div class="profile" id="home">
                        <hr>


                        <div class="form-row">
                            <div class="col-sm-12 col-md-6">
                                <label for="inputEmail4">Username</label>
                                <div class="input-group">
                                    <input type="text" name='user' value="<?php echo $Username; ?>" class="form-control"
                                        id="username_shop" onkeyup="checkuserup()">
                                    <span id="Username-Err"></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="inputPassword4">Email</label>
                                <div class="input-group">
                                    <input type="text" name='email' value="<?php echo $Email; ?>" class="form-control"
                                        id="Up_email_shop" onkeyup="checkemailup()">
                                    <span id="email-Err"></span>
                                </div>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="col-sm-12 col-md-6">
                                <label for="inputEmail4">Shop name</label>
                                <div class="input-group">
                                    <input type="text" name='sname' value="<?php echo$shop_Name; ?>"
                                        class="form-control" id="upshop_name" onkeyup="checkshopNameup()">
                                    <span id="Shop_name-Err"></span>
                                </div>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="col-sm-12 col-md-6 mt-3">
                                <label for="inputPassword4">Payment information</label>
                                <div class="input-group">
                                    <textarea class="form-control" name='pdscr' rows="4"
                                        id="up_Payment" onkeyup="checkpayShopup()"><?php echo $payment_Information;?></textarea>
                                    <span id="Payment-Err" style="margin-top: 30px;"></span>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-sm-12 col-md-6 mt-3">
                                <label for="inputPassword4">Shop description</label>
                                <div class="input-group">
                                    <textarea class="form-control" name='shopDsc' rows="4"
                                        id="up-des"  onkeyup="checkDesShopup()"><?php echo $shop_Description; ?></textarea>
                                    <span id="Shop_des-Err" ></span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                                <button class="btn btn-lg " type="submit" id="updatebtnShop"> Update <i
                                        class="fa-light fa-badge-check"></i></button>
                            </div>
                        </div>

                        <hr>


                    </div>
                    <!--/tab-pane-->
                    <div class="tab-pane" id="settings">



                    </div>
                    <!--/col-9-->

                </div>
                <!--/row-->
    </form>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
$(document).ready(function() {

    // $('#updatebtn').on('click', function() {
    //     event.preventDefault();

    //     $('#updatemodal').modal('show');

    // });

    //  validation start

    $('#updatebtnShop').click(function () {
        event.preventDefault(); // Prevent the default behavior of the click event

        var isValid = true;

        // Perform your validation checks here
        if (!checkuserup() || !checkemailup() || !checkshopNameup()|| !checkpayShopup() || !checkDesShopup() || !checkfileLogoup() ||!validateTradeup()) {
            isValid = false;
            
            $("#message-up").html(`<div class="alert alert-warning">Please fill all required fields</div>`);
            console.log("Validation error");
            window.scrollTo({
            top: 0,
            behavior: 'smooth'
                            });
        }

            if (isValid) {
        console.log("Validation successful");
        $("#message-up").html("");
        var form = $('#customer-form-update')[0];
        var data = new FormData(form);

        // Show the modal
        $('#updatemodalShop').modal('show');

        // Event handler for the update button in the modal
        $('#updatemodalShop').on('click', '[name="submitUP"]', function() {
            $.ajax({
                type: "POST",
                url: "customer_process.php",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#message-up').html(data);
                    $('#updatemodal').modal('hide'); // Hide the modal

                    // var message_new_customer = "Data updated successfully inserted";
                    // window.location.href = "customer_accountT.php?message_new_customer=" + encodeURIComponent(message_new_customer);

                },
                error: function () {
                    console.log("Error submitting form");
                    $("#message-up").html("<div class='alert alert-danger'>Error submitting form</div>");
                }
            });
        });
    }
    });



    // 
});



// start username validation

function checkuserup() {

    var pattern = /^[A-Za-z0-9]+$/;
    var user = $('#username_shop').val();
    var validuser = pattern.test(user);

    if (user.length == 0) {
        $('#Username-Err').html('*Username is required');
        return false;
    } else if (!user.match(/^.{4,20}$/)) {
        $('#Username-Err').html('*At least 4 characters.');
        return false;
    } else if (!user.match(/^(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])\S{4,}$/)) {
        $('#Username-Err').html('*Not less than 3 letters.');
        return false;
    } else if (!user.match(/^(?=[a-zA-Z]\w{3,})(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])\w+$/)) {
        $('#Username-Err').html('*Must start with a letter.');
        return false;
    } 
    else {
                    $('#Username-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                    return true; // Set the variable to true if the username is valid
    }
    
}

// 

function checkemailup() {  
    var email = $('#Up_email_shop').val();
   
    // 
    if(email.length == 0){
        $('#email-Err').html('*email is required');
          return false;

    }
     else if(!email.match (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
        $('#email-Err').html('*invalid email.');

         return false;
       }
       else {
        $('#email-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
        return true; // Set the variable to true if the username is valid
       

    }

    // 
}



function checkshopNameup(){
    var shopName = $('#upshop_name').val();
    var shopNameN=shopName.trim();
   // 
   if(shopName.length == 0){
       $('#Shop_name-Err').html('*shop Name is required');
         return false;

   }
    else if(!shopName.match (/^(?:[a-zA-Z]+\s*){4,}$/)){
       $('#Shop_name-Err').html('*must be only letters.');

        return false;
      }

      else if(!shopName.match (/^[a-zA-Z\s]{4,}$/)){
       $('#Shop_name-Err').html('*At least 4 letters.');

        return false;
      }
       
        
         else {
              $('#Shop_name-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
              return true;
             }
   // end shopname
            }

        //     SHOP DSC

            function checkDesShopup(){
                var shopDES = $('#up-des').val();


                 if(shopDES.length == 0){
                $('#Shop_des-Err').html('*Shop description is required');
                    return false;

                   }
                else if(!shopDES.match (/^(?=(?:[^a-zA-Z]*[a-zA-Z]){4,30})[\w\d\s_!@#$%^&*()\/.,#-*?!~*e-]{10,}$/)){
                $('#Shop_des-Err').html('*At least 10 letters.')

                    return false;
                }

                else{
                $('#Shop_des-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                return true;
                }

                

                
            }


        //    END 


        // payment

        function checkpayShopup(){
                var shopPAY = $('#up_Payment').val();


                 if(shopPAY.length == 0){
                $('#Payment-Err').html('*Shop payments is required');
                    return false;

                   }
                else if(!shopPAY.match (/^IBAN:[A-Z0-9]{22}$/)){
                $('#Payment-Err').html('*Must start with IBAN:(22 numbers and letters)');

                    return false;
                }

                else{
                $('#Payment-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                return true;
                }

                

                
            }
 


        // END payment


   // ckeck logo


function checkfileLogoup() {
    var fileInput = $('#uplogo')[0];
    var file = fileInput.files[0];

    if (!file) {
        $('#logo-Err').html('');
          return true; // No file selected, validation passes
    }
    else{

        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
          if (!allowedTypes.includes(file.type)) {
              $('#logo-Err').html('*Only JPEG, PNG, and JPG images are allowed.');
              return false;
          }

          // Check file size
          var maxSize = 10 * 1024 * 1024; // 10 MB
          if (file.size > maxSize) {
              $('#logo-Err').html('*Logo size should be less than 10 MB');
              return false;
          }

          $('#logo-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
          return true;


    }
}



  //    end logo


//   trade rejetsrt

function validateTradeup() {
    var fileInput = $('#upTrade')[0];
    var file = fileInput.files[0];

    if (!file) {
        $('#Trade-Err').html('');
          return true; // No file selected, validation passes
    }
    else{

        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
          if (!allowedTypes.includes(file.type)) {
              $('#Trade-Err').html('*Only JPEG, PNG, and JPG images are allowed.');
              return false;
          }

          // Check file size
          var maxSize = 10 * 1024 * 1024; // 10 MB
          if (file.size > maxSize) {
              $('#Trade-Err').html('*Logo size should be less than 10 MB');
              return false;
          }

          $('#Trade-Err').html('<i class="fa fa-duotone fa-circle-check"></i>');
          return true;


    }
}
// End  validation
</script>

<?php
include($tmpl . 'footer.php'); //<!-- footer -->
}
    //Redirect to login
    else{echo"You are to authzied to enter this page";
        header('location:../Users/index.php'); 
        }
    ?>
?>