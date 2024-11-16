<?php
session_start();
$pageTitle ="Register";
$NoNavbar ="";
include("intil.php");                       //<!--  rounter -->
?>
<style>
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

  <div class="container  mt-3 bg-white mb-3  " style="width:100%;     min-height: 760px; ">
  <div id="message"></div>
      <div class="row  justify-content-center mb-4">
        <h2 class="R-h2"> Customer Register</h2>
      </div>
  <form method="post" id="customer-form"  enctype="multipart/form-data" >
    <div class="form-row ">
      <div class=" col-sm-12 col-md-6 ">
        <label for="inputEmail4">Username</label>
        <div class="input-group">
          <input type="text" class="form-control" name="user"  placeholder="Enter your Username" id="input-username">
          <span id="username_err"> </span>
        </div>
      </div>
      <div class="form-group col-sm-12 col-md-6">
        <label for="inputPassword4">Password</label>
        <div class="input-group">
          <input type="password" class="form-control"  name="pass" placeholder="Enter your Password" id="input-password" >
          <span id="password_err"> </span>
        </div>
      </div>
    </div>

    <!--  -->
    <div class="form-row ">
      <div class=" col-sm-12 col-md-6 ">
        <label for="inputEmail4">Email</label>
        <div class="input-group">
          <input type="text" class="form-control" name="mil" placeholder="Enter your Email" id="input-Email">
          <span id="email_err"> </span>
        </div>
      </div>
    
    </div>

<!--  -->

    <!--  -->
    <div class="form-row mt-5">
      <div class=" col-sm-12 col-md-6 ">
      <label for="inputphone">Phone Number (optional)</label>
                <div class="input-group">
                  <input type="phone" class="form-control" id="phone" name="phone" placeholder="97335538234" id="input-phone" >
                  <span id="phone-err"> </span>
                </div>
      </div>
      <div class="form-group col-sm-12 col-md-6">
        <label for="inputPassword4">Full name (optional)</label>
        <div class="input-group">
          <input type="text" class="form-control" name="fname"  placeholder="Enter your Full name" id="input-name" >
          <span id="fname-err"> </span>
        </div>
      </div>
    </div>

<!--  -->


    <div class="form-row ">
        <div class="form-group col-md-6"><div class="input-address">
            <label for="inputAddress">Address (optional)</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your Address">
            <span id="address-err"></span></div>

      </div>
     
    
    </div>

    
    <!--  -->
    <div class="form-row mt-5">
  
      <div class=" col-sm-6 col-md-4 ">
      <span id="gender-err"> </span>
      <label for="inputState">Gender (optional)</label>
        <!-- <select id="gender"  name="gender" class="form-control">
          <option selected>Choose...</option>
          <option>Male</option>
          <option>Female</option>
        </select> --><br>

        <input type="radio" name="gender" value="male" style="margin-left: 22px;"> 
         <label for="Male">Male</label><br>
        <input type="radio" name="gender" value="female" style="margin-left: 22px;"> 
         <label for="Female">Female</label><br>


      </div>
      <div class="form-group col-sm-6 col-md-4">
        <label for="input">Age (optional)</label>
        <div class="input-group">
          <input type="number" class="form-control"  name="age" placeholder="Enter your Age" min=5; id="age">
          <span id="age-err"> </span>
        </div>
      </div>
      <div class="form-group col-sm-6  col-md-4">
      <label for="input">Account image (optional)</label>
      <div class="input-group">
        <input type="file" name='img'placeholder="Enter your Password" id="input-img" >
        <span id="img-err" style="
    margin-top: 27px;
"></span>
      </div>
    </div>
    </div>

<!--  -->



    <div class="d-flex justify-content-center">
        <div class="buttons_R mt-5 "style="
            display: inline-flex;
            justify-content: space-evenly;
            align-items: center;">
            <a href="Control_Register.php" class="ml-2 mr-2">Cancel</a>    

            <button type="button" class="btn  mx-auto  R-btn"  id="submitbtncus" >Register</button>
        </div>

        </div>
  </form>

  </div>

</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>

//   validation
$(document).ready(function () {
    $('#input-username').on('input', function () {
        checkuser();
    });
    $('#input-password').on('input', function () {
        checkpass();
    });

    $('#input-Email').on('input', function () {
        checkemail();
    });
    $('#phone').on('input', function () {
        checkphone();
    });
    $('#input-name').on('input', function () {
        checkname();
    });
    $('#address').on('input', function () {
        checkAddress();
    });
    $('#input-img').on('input', function () {
        checkimg();
    });
    $('#age').on('input', function () {
        checkage();
    });



    // $('#input_Trade_shop').on('input', function () {
    //     checkTrade();
    // });

    $('#submitbtncus').click(function () {
        var isValid = true;

        // Perform your validation checks here
        if (!checkuser() || !checkemail()  || !checkpass() ||  !checkname()  || !checkphone() || !checkAddress() || !checkimg() || !checkage()) {
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
            var form = $('#customer-form')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "customer_process.php",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#message').html(data);
                    var message_new_customer = "Data successfully inserted";
                    window.location.href = "index.php?message_new_customer=" + encodeURIComponent(message_new_customer);

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
    var user = $('#input-username').val();
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
    var pass = $('#input-password').val();
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
    var email = $('#input-Email').val();
   
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


//   phone 

function checkphone() {
    var phone = $('#phone').val();

        // 
        
        if (!phone) {
            $('#phone-err').html('');
            return true; // No file selected, validation passes
        }
        else
        {
 

        if(!phone.match (/^973\d{8}$/)){
        $('#phone-err').html('*invalid phone.');

         return false;
        }

            $('#phone-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;

        }
    }
// END 

//   Full name 

function checkname() {
    var name = $('#input-name').val();

        // 
        
        if (!name) {
            $('#fname-err').html('');
            return true; // No file selected, validation passes
        }
        else
        {
 

        if(!name.match (/^(?:[a-zA-Z][a-zA-Z\s]*[a-zA-Z])$/)){
        $('#fname-err').html('*invalid Name.');

         return false;
        }

            $('#fname-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;

        }
    }
// END 

//   Address

function checkAddress() {
    var address = $('#address').val();

        // 
        
        if (!address) {
            $('#address-err').html('');
            return true; // No address selected, validation passes
        }
        else
        {
 



            $('#address-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;

        }
    }
// END 



//   Age

function checkage() {
    var age = $('#age').val();

        // 
        
        if (!age) {
            $('#age-err').html('');
            return true; // No address selected, validation passes
        }
        else
        {
            if(!age.match (/^(?:[1-9][0-9]?|100)$/)){
        $('#age-err').html('*invalid age.');

         return false;
        }
 



            $('#age-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;

        }
    }
// END 



     



//   img 

function checkimg() {
        // 
        var fileimg = $('#input-img')[0];
        var file = fileimg.files[0];


        if (!file) {
            $('#img-err').html('');
            return true; // No file selected, validation passes
        }
        else
        {
                // Check file type
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                $('#img-err').html('*Only JPEG, PNG, and JPG images are allowedTTT');
                return false;
            }

            // Check file size
            var maxSize = 10 * 1024 * 1024; // 10 MB
            if (file.size > maxSize) {
                $('#img-err').html('*Logo size should be less than 10 MB');
                return false;
            }

            $('#img-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
            return true;

        }
    }
// END 
// end validation


</script>

</body>
</html>