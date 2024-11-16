<?php
session_start();
$pageTitle ="Register";
$NoNavbar ="";
include("intil.php");                       //<!--  rounter -->

?>


<section class="Register">   

  <div class="container  mt-3 bg-white  " style="width:100%;     min-height: 540px; ">
      <div class="row  justify-content-center mb-4">
        <h2 class="R-h2"> Register</h2>
      </div>
  <form  >
    <div class="form-row ">
      <div class=" col-sm-12 col-md-6 ">
        <label for="inputEmail4">Username</label>
        <div class="input-group">
          <input type="text" class="form-control"  placeholder="Enter your Username" id="input-username" onkeyup="validateName()">
          <span id="Username-err"> </span>
        </div>
      </div>
      <div class="form-group col-sm-12 col-md-6">
        <label for="inputPassword4">Password</label>
        <div class="input-group">
          <input type="password" class="form-control"  placeholder="Enter your Password" id="input-password" onkeyup=" validatePass()">
          <span id="password-err"> </span>
        </div>
      </div>
    </div>



    <div class="form-row">
            <div class="form-group col-md-6">
                  <label for="inputAddress">Phone Number</label>
                <div class="input-group">
                  <input type="phone" class="form-control" id="inputAddress" placeholder="Enter your Phone Number" id="input-phone" onkeyup="validatePhone()" >
                  <span id="phone-err"> </span>
                </div>

            </div>

          <div class="form-group col-md-6 ">
                  <label for="inputAddress">Full name</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="Enter your Full name">
            </div>
      </div>


    <div class="form-row ">
        <div class="form-group col-md-6">
            <label for="inputAddress">Email</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Enter your Email">
      </div>
      <div class="form-group col-md-6">
          <label for="inputAddress">Age</label>
          <input type="number" class="form-control" id="inputAddress" placeholder="Your Age">
      </div>
    </div>
    <div class="form-group ">
        <label for="inputState">Gender</label>
        <select id="inputState" class="form-control">
          <option selected>Choose...</option>
          <option>Male</option>
          <option>Female</option>
        

        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="inputState">City</label>
        <select id="inputState" class="form-control">
          <option selected>Choose...</option>
          <option>Manama</option>
          <option>Moharaq</option>
          <option>Hamad Town</option>

        </select>
      </div>

    </div>
    <button type="submit" class="btn  mx-auto  R-btn "  id="submit-err" >Register</button>
  

  </form>

  </div>

</section>

<?php
include($tmpl .'footer.php') ;             //<!-- footer -->



?>