<?php
session_start();
$pageTitle ="Register";
$NoNavbar ="";

include("intil.php"); 
include("connection.php");


$stat = $con->prepare("select * from category ");
$stat->execute(array());
$rows = $stat->fetchAll();  // get all rows of data from DB
$count = $stat->rowCount();  // count the number of rows
          

?>
<style>
      .select-btn{
      display: flex;
      height: 50px;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px;
      border-radius: 8px;
      cursor: pointer;
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  }
  .select-btn .btn-text{
      font-size: 17px;
      font-weight: 400;
      color: #333;
  }
  .select-btn .arrow-dwn{
      display: flex;
      height: 21px;
      width: 21px;
      color: #fff;
      font-size: 14px;
      border-radius: 50%;
      background: #6e93f7;
      align-items: center;
      justify-content: center;
      transition: 0.3s;
  }
  .select-btn.open .arrow-dwn{
      transform: rotate(-180deg);
  }
  .list-items{
      position: relative;
      margin-top: 15px;
      border-radius: 8px;
      padding: 16px;
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      display: none;
      max-height: 320px; 
      overflow: auto;
  }
  .select-btn.open ~ .list-items{
      display: block;
  }
  .list-items .item{
      display: flex;
      align-items: center;
      list-style: none;
      height: 50px;
      cursor: pointer;
      transition: 0.3s;
      padding: 0 15px;
      border-radius: 8px;
  }
  .list-items .item:hover{
      background-color: #e7edfe;
  }
  .item .item-text{
      font-size: 16px;
      font-weight: 400;
      color: #333;
  }
  .item .checkbox{
      display: flex;
      align-items: center;
      justify-content: center;
      height: 16px;
      width: 16px;
      border-radius: 4px;
      margin-right: 12px;
      border: 1.5px solid #c0c0c0;
      transition: all 0.3s ease-in-out;
  }
  .item.checked .checkbox{
      background-color: #4070f4;
      border-color: #4070f4;
  }
  .checkbox .check-icon{
      color: #fff;
      font-size: 11px;
      transform: scale(0);
      transition: all 0.2s ease-in-out;
  }
  .item.checked .check-icon{
      transform: scale(1);
  }

  .buttons_R a{
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

<section class="Register">   

  <div class="container  mt-3 mb-3 bg-white  " style="width:100%;     min-height: 900px; ">
      <div class="row  justify-content-center mb-4">
        <h2 class="R-h2"> Request to open a shop </h2>
      </div>
      <div id="message"></div>

  <form   method="post" id="shop-form"  enctype="multipart/form-data">
                <div class="form-row">
                <div class="col-sm-12 col-md-6">
                    <lable for="inputEmail4">Username</lable>
                    <div class="input-group">
                    <input type="text" name='user'class="form-control" placeholder="Enter your Username" id="input-username_shop">
                    <span id="username_err"></span>
                    </div>
                </div>
                <div class=" col-sm-12 col-md-6">
                    <lable for="inputPassword4">Password</lable>
                    <div class="input-group">
                    <input type="password"name='pass' class="form-control" placeholder="Enter your Password" id="input-password_shop">
                    <span id="password_err"></span>
                    </div>
                </div>
                </div>

            <div class="form-row">
            <div class="form-group col-md-6 ">
                <lable for="inputAddress">Email</lable>
                <div class="input-group">
                <input type="text" name='mil'class="form-control" id="email-shop" placeholder="Enter your Email">
                <span id="email_err"></span>
                </div>


            </div>
            </div>

            <h2 class="mt-4 mb-4">Shop details:</h2>

            <div class="shop_details">
            <div class="form-row">
                <div class="col-sm-12 col-md-6">
                <lable for="inputEmail4">Shop name</lable>
                <div class="input-group">
                    <input type="text" name='sname'class="form-control" placeholder="Enter shop name" id="input_shop_name">
                    <span id="Shop_name-err"></span>
                </div>
                </div>
                    <div class="form-group col-sm-6 col-md-3">
                    <div class="input-group">
                    <span id="Logo-err" style="margin-top: 51px;"> </span></div>
                    <lable for="logo">Logo</lable>
                    <div class="input-group">
                        <input type="file" name="logo" id="logo">
                    </div>
                
                </div>
                <div class="form-group col-sm-6 col-md-3">
                <div class="input-group">
                    <span id="Trade-err" style="margin-top: 51px;"> </span></div>
                <lable for="inputPassword4">Trade register (optional)</lable>
                <div class="input-group">
                    <input type="file" name='trade'placeholder="Enter your Password" id="input_Trade_shop">
            
                </div>
                </div>
            </div>


            
            <div class="form-row">
                <div class="col-sm-12 col-md-6">
                <lable for="input4">Payment information</lable>
                <div class="input-group">
                    <input type="text" name='pay'class="form-control" placeholder="IBAN: BH67BMAG00000000000" id="input_Payment" onkeyup="validateName()">
                    <span id="Payment-err"></span>
                </div>
                </div>

            </div>
            <!--  -->
            <div class="form-row mt-5">
                <!--  -->  
                <div class="col-sm-12 col-md-6">
                <lable for="shop_dsc">Shop description</lable>
                <div class="input-group">
                    <textarea class="form-control" name='sdsc'rows="4" id="input-des_shop"></textarea>
                    <span id="Shop_des-err"></span>
                </div>
                </div>

                <!--  -->
                <div class="col-sm-12 col-md-6">
                <div class="input-group">
                            <span id="category-err"></span>
                            </div>
                <lable for="shop_cato">Select shop categories</lable>
                

                    <div class="select-btn form-control"  >

                                <span class="btn-text">Chooses...</span>
                                <span class="arrow-dwn">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <ul class="list-items  "style="
                                                            background-color: #dcdcddf5;
                                                            border: 1px solid #8d8484;">

                                                            <!-- <span class="checkbox">
                                <i class="fa-solid fa-check check-icon"></i>
                                </span> -->

                            <?php
                        if ($count > 0) {
                            foreach ($rows as $row) {
                            
                                echo '
                                <li class="item">
                                
                                <input type="checkbox" name="category[]" value="'.$row['Category_ID'].'"
                                    style=" margin-right: 10px;">
                                <span class="item-text"> ' . $row['Category_name'] . '</span>
                            </li>  
                            
                            

                                ';
                            }
                        } else {
                            echo '<div style="text-align: center; margin: 207px auto;">No data found.</div>';
                        }
                        ?>
                            
                            </ul>
                
                </div>
                
                </div>
            </div>

            <div class="d-flex justify-content-center">
                    <div class="buttons_R mt-5 "style="
                        display: inline-flex;
                        justify-content: space-evenly;
                        align-items: center;
                        
                        ">
                        <a href="Control_Register.php" class="ml-2 mr-2">Cancel</a> 
                        
                        <button type="button" id="submitbtnShop" class="btn"
                        style="padding: 4.5px 20px;
                            font-size: 18px;">Submit</button>


                        <!-- <button type="submit"
                        class="btn  mx-auto  R-btn    mt-5 mb-5"  id="submitbtn" 
                        style="padding: 5px 52px;
                            font-size: 18px;"
                        name="send"> Send</button>  -->
                    </div>
                    </div>
            </div>

            <!--  -->


            </div>
     
         </form>
  </div>

</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>
  // slection 
   const selectBtn = document.querySelector(".select-btn"),
      items = document.querySelectorAll(".item");

  selectBtn.addEventListener("click", () => {
      selectBtn.classList.toggle("open");
   });
  //  end slection

//   validation
$(document).ready(function () {
    $('#input-username_shop').on('input', function () {
        checkuser();
    });
    $('#input-password_shop').on('input', function () {
        checkpass();
    });

    $('#email-shop').on('input', function () {
        checkemail();
    });

    $('#input_shop_name').on('input', function () {
        checkshopName();
    });

    $('#input-des_shop').on('input', function () {
        checkDesShop();
    });

    $('#input_Payment').on('input', function () {
        checkpayShop();
    });

    $('input[name="category[]"]:checked').on('input', function () {
        validateCategories();
    });

    $('#logo').on('input', function() {
        checkfileLogo();
    });


    $('#input_Trade_shop').on('input', function () {
        checkTrade();
    });

    $('#submitbtnShop').click(function () {
        var isValid = true;

        // Perform your validation checks here
        if (!checkuser() ||!checkemail()  ||!checkpass()  || !checkshopName() || !checkpayShop()||  !checkDesShop()  || !validateCategories() || !checkfileLogo() || !checkTrade()  ) {
            isValid = false;
            
            $("#message").html(`<div class="alert alert-warning">Please fill all required fields</div>`);
            console.log("Validation error");
            window.scrollTo({
            top: 0,
            behavior: 'smooth'
                            });
        }

        if (isValid) {
            console.log("Validation successful");
            $("#message").html("");
            var form = $('#shop-form')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "shop_process.php",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#message').html(data);
                    var message = "Data successfully inserted";
                    window.location.href = "index.php?message=" + encodeURIComponent(message);

                },
                error: function () {
                    console.log("Error submitting form");
                    $("#message").html("<div class='alert alert-danger'>Error submitting form</div>");
                }
            });
        }
    });
});


function checkuser() {
    var pattern = /^[A-Za-z0-9]+$/;
    var user = $('#input-username_shop').val();
    var validuser = pattern.test(user);

    if (user.length == 0) {
        $('#username_err').html('*Username is required');
        return false;
    } else if (!user.match(/^.{4,20}$/)) {
        $('#username_err').html('*At least 4 characters.');
        return false;
    } else if (!user.match(/^(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])\S{4,}$/)) {
        $('#username_err').html('*Not less than 3 letters.');
        return false;
    } else if (!user.match(/^(?=[a-zA-Z]\w{3,})(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])\w+$/)) {
        $('#username_err').html('*Must start with a letter.');
        return false;
    } else {
        // Check if the username is already taken
        var isUsernameValid = false; // Introduce a variable to track username validity

        $.ajax({
            type: "POST",
            url: "checkUsername.php",
            data: { username: user },
            async: false, // Set async to false to wait for the response
            success: function (response) {
                if (response == 1) {
                    $('#username_err').html('*Username is already taken.');
                } else {
                    $('#username_err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                    isUsernameValid = true; // Set the variable to true if the username is valid
                }
            },
            error: function () {
                console.log("Error checking username");
                // Handle the error accordingly
            }
        });

        return isUsernameValid; // Return the username validity
    }
}
function checkpass() {
    console.log("sass");
    var pattern2 = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    var pass = $('#input-password_shop').val();
    var validpass = pattern2.test(pass);
    // 
    if(pass.length == 0){
        $('#password_err').html('*Password is required');
          return false;

    }
     else if(!pass.match (/^.{6,20}$/)){
        $('#password_err').html('*At least 6 letters.');

         return false;
       }
       else{
        $('#password_err').html('<i class="fa fa-duotone fa-circle-check"></i>');
       return true;
       }
     

}

function checkemail() {  
    var email = $('#email-shop').val();
   
    // 
    if(email.length == 0){
        $('#email_err').html('*email is required');
          return false;

    }
     else if(!email.match (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
        $('#email_err').html('*invalid email.');

         return false;
       }
       else {
        // Check if the Email is already taken
        var isemailValid = false; // Introduce a variable to track username validity

        $.ajax({
            type: "POST",
            url: "checkEmail.php",
            data: { email: email },
            async: false, // Set async to false to wait for the response
            success: function (response) {
                if (response == 1) {
                    $('#email_err').html('*Email is already taken.');
                } else {
                    $('#email_err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                    isemailValid = true; // Set the variable to true if the username is valid
                }
            },
            error: function () {
                console.log("Error checking username");
                // Handle the error accordingly
            }
        });

        return isemailValid; // Return the username validity
    }

    // 
}



function checkshopName(){
    var shopName = $('#input_shop_name').val();
    var shopNameN=shopName.trim();
   // 
   if(shopName.length == 0){
       $('#Shop_name-err').html('*shop Name is required');
         return false;

   }
    else if(!shopName.match (/^(?:[a-zA-Z]+\s*){4,}$/)){
       $('#Shop_name-err').html('*must be only letters.');

        return false;
      }

      else if(!shopName.match (/^[a-zA-Z\s]{4,}$/)){
       $('#Shop_name-err').html('*At least 4 letters.');

        return false;
      }
    
        // Check if the shopName is already taken
        else {
        // Check if the shop name is already taken
        var isShopNameValid = false;

        $.ajax({
            type: "POST",
            url: "checkShopName.php",
            data: { shopName: shopName },
            async: false,
            success: function (response) {
                if (response == 1) {
                    $('#Shop_name-err').html('*Shop name is already taken.');
                } else {
                    $('#Shop_name-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                    isShopNameValid = true;
                }
            },
            error: function () {
                console.log("Error checking Shop name");
                // Handle the error accordingly
            }
        });

        return isShopNameValid;
    }




   // end shopname
            }

        //     SHOP DSC

            function checkDesShop(){
                var shopDES = $('#input-des_shop').val();


                 if(shopDES.length == 0){
                $('#Shop_des-err').html('*Shop description is required');
                    return false;

                   }
                else if(!shopDES.match (/^(?=(?:[^a-zA-Z]*[a-zA-Z]){4,30})[\w\d\s_!@#$%^&*()\/.,#-*?!~*e-]{10,}$/)){
                $('#Shop_des-err').html('*At least 10 letters.')

                    return false;
                }

                else{
                $('#Shop_des-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                return true;
                }

                

                
            }


        //    END 


        // payment

        function checkpayShop(){
                var shopPAY = $('#input_Payment').val();


                 if(shopPAY.length == 0){
                $('#Payment-err').html('*Shop payments is required');
                    return false;

                   }
                else if(!shopPAY.match (/^IBAN:[A-Z0-9]{22}$/)){
                $('#Payment-err').html('*Must start with IBAN:(22 numbers and letters)');

                    return false;
                }

                else{
                $('#Payment-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                return true;
                }

                

                
            }
 


        // END payment


        // catogry 
        function validateCategories() 
        {
            var checkboxes = document.querySelectorAll('input[name="category[]"]:checked');
            if (checkboxes.length === 0) {
                $('#category-err').html('*Please select at least one category');
                return false;
            } else {
                $('#category-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                return true;
            }
        }


        //  END  catogry

   // ckeck logo

//    

function checkfileLogo() {
    var fileInput = $('#logo')[0];
    var file = fileInput.files[0];

    if (!file) {
        $('#Logo-err').html('*Logo is required');
        return false;
    }

    // Check file type
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
        $('#Logo-err').html('*Only JPEG, PNG, and JPG images are allowed');
        return false;
    }

    // Check file size
    var maxSize = 10 * 1024 * 1024; // 10 MB
    if (file.size > maxSize) {
        $('#Logo-err').html('*Logo size should be less than 10 MB');
        return false;
    }



    $('#Logo-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
    return true;
}



  //    end logo


//   trade rejetsrt

function checkTrade() {
        // 
        var fileTrade = $('#input_Trade_shop')[0];
        var file = fileTrade.files[0];


        if (!file) {
            $('#Trade-err').html('');
            return true; // No file selected, validation passes
        }
        else
        {
                // Check file type
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                $('#Trade-err').html('*Only JPEG, PNG, and JPG images are allowedTTT');
                return false;
            }

            // Check file size
            var maxSize = 10 * 1024 * 1024; // 10 MB
            if (file.size > maxSize) {
                $('#Trade-err').html('*Logo size should be less than 10 MB');
                return false;
            }

            $('#Trade-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;

        }
    }
// END trade




// function password_show_hide() {
//     console.log('ok');
//     var x = document.getElementById("password");
//     var show_eye = document.getElementById("show_eye");
//     var hide_eye = document.getElementById("hide_eye");
//     hide_eye.classList.remove("d-none");
//     if (x.type === "password") {
//         x.type = "text";
//         show_eye.style.display = "none";
//         hide_eye.style.display = "block";
//     } else {
//         x.type = "password";
//         show_eye.style.display = "block";
//         hide_eye.style.display = "none";
//     }
// }




// end validation


</script>

</body>
</html>
