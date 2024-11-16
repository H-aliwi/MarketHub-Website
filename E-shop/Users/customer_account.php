<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
if (isset($_SESSION['usernameA'])) {
    $NoFooter ="";


    if (isset($_POST['submit-update-customer'])) {
        include("connection.php");

        // Get data that comes from the form
        $username = $_POST['username'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $Pnumber = $_POST['Pnumber'];
        $address = trim($_POST['address']);
        $age = $_POST['age'];
        $gender = $_POST['gender'];

        
        $Id = $_SESSION['UserID'];
        $item_img_name = $_FILES['img']['name'];
        // accessing image name
        $item_img_tmp = $_FILES['img']['tmp_name'];            // accessing image tmp_name
        $item_img_err = $_FILES['img']['error'];                // accessing image error
        // SQL statement
        if ($_FILES['img']['name'] != '') {
            $item_img_name = $_FILES['img']['name'];
            // accessing image name
            $item_img_tmp = $_FILES['img']['tmp_name']; // accessing image tmp_name
            $item_img_err = $_FILES['img']['error']; // accessing image error
        
            // SQL statement
            $stat = $con->prepare("UPDATE customer SET Username = ?, Email = ?, fullname = ?, Phone_number = ?, address = ?, age = ?,gender=?, Account_img = ? WHERE CustomerID = ?");
            $stat->execute(array($username, $email, $name, $Pnumber, $address, $age, $gender,$item_img_name, $Id));
        
            if ($stat->rowCount() > 0) {
                move_uploaded_file($item_img_tmp, "layout/images/C_account/$item_img_name");
                echo "<script>alert('Account information has been updated successfully.')</script>";
            }
        } else {
            // No new file uploaded, keep the old file data
            $stat = $con->prepare("UPDATE customer SET Username = ?, Email = ?, fullname = ?, Phone_number = ?, address = ?, age = ?,gender=? WHERE CustomerID = ?");
            $stat->execute(array($username, $email, $name, $Pnumber, $address, $age, $gender,$Id));
            echo "<script>alert('Account information has been updated successfully.')</script>";
        }
    }

    $pageTitle = "Profile";

    include("intil.php");                     //<!--  rounter -->
        // make sure that the UserID is a number eles make it 0
          $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID'])  ? intval($_GET['UserID']) : 0;
          $stat =  $con->prepare("select * from customer where CustomerID = ?");
          $stat->execute(array($userid));
          $row=$stat->fetch();     // fetch Data from DB
          $count= $stat->rowCount();

          if ( $count > 0)  // if ID is exist show the form
          {

            // echo  $row['Username'];
            // echo  $row['Email'];
            // echo  $row['fullname'];
            // echo  $row['address'];
            // echo  $row['age'];
            // echo  $row['gender'];
            // echo  $row['Account_img'];
            ?>
<div class="container bootstrap snippet  mt-3 mb-3 bg-white ">
      <div id="message"></div>
    <div class="row  justify-content-center m-2">
        <h2 class="R-h2"> Edit Profile </h2>
    </div>


    <div class="row mt-2 ">
        <div class="col-sm-3  ">
            <!--left col-->
            <form  method="POST" id="customer-form-update" enctype="multipart/form-data">

                <div class="text-center">
                    <img src="layout/images/C_account/<?php echo $row['Account_img']; ?>"
                        class="avatar img-circle img-thumbnail" name="img" style="border-radius: 50%;" alt="avatar">
                    <h6>Upload a different image...</h6>
                    <div class="input-group">
                    <input type="file" name="img"  id="input-img-customer" class="text-center center-block file-upload" onchange="checkimg()">
                    <span id="img-err" style="margin-top: 27px; "></span>
                </div>
            </div>
                </hr><br>

        </div>
        <!--/col-3-->
        <div class="col-sm-9 ">



            <div class="profile" id="home">
                <hr>

                <!-- update POP UP FORM (Bootstrap MODAL) -->
                <div class="modal fade" id="updatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <button name="submit-update-customer" class="btn " type="submit">Update <i
                                        class="fa-light fa-badge-check"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- modal end -->

                <div class="form-row">
                    <div class="col-sm-12 col-md-6">
                        <lable for="inputEmail4">Username</lable>
                        <div class="input-group">
                            <input type="text" name='username' value="<?php echo $row['Username'];?>"
                                class="form-control" id="input-username"  onkeyup="checkuser()">
                            <span id="username_err"></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <lable for="inputPassword4">Email</lable>
                        <div class="input-group">
                            <input type="text" name='email' value="<?php echo   $row['Email']  ?>" class="form-control"
                                id="input-Email" onkeyup="checkemail()">
                            <span id="email_err"></span>
                        </div>
                    </div>
                </div>



                <!--  -->
                <!--  -->
                <div class="form-row">
                    <div class="col-sm-12 col-md-6">
                        <lable for="name">Full name</lable>
                        <div class="input-group">
                            <input type="text" name='name' value="<?php echo   $row['fullname']  ?>"
                                class="form-control" id="input-name" onkeyup="checkname()">
                            <span id="fname-err"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <lable for="Phone">Phone number</lable>
                        <div class="input-group">
                            <input type="text" name='Pnumber' value="<?php echo $row['Phone_number'] ?>"
                                class="form-control" id="phone" onkeyup="checkphone()">
                            <span id="phone-err"></span>
                        </div>
                    </div>

                </div>

                <div class="form-row">

                    <div class="col-sm-12 col-md-6 mt-3">
                        <lable for="Address">Address</lable>
                        <div class="input-group">
                            <textarea class="form-control" name='address' rows="4"
                                id="iaddress" onkeyup="checkAddress()"> <?php echo   $row['address']  ?></textarea>
                            <span id="address-err"></span>
                        </div>
                    </div>

                </div>
                <!--  -->
                <div class="form-row mt-5">

                    <div class=" col-md-6 ">
                        <lable for="inputState">Gender (optional)</lable>
                        <!-- <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select> --><br>
                        <input type="radio" name="gender" value="male" style="margin-left: 22px;" <?php if ($row['gender'] === 'male') echo 'checked'; ?>>
                        <label for="Male">Male</label><br>
                        <input type="radio" name="gender" value="female" style="margin-left: 22px;" <?php if ($row['gender'] === 'female') echo 'checked'; ?>>
                        <label for="Female">Female</label><br>

                    </div>
                    <div class="form-group col-md-6">
                        <lable for="Age">Age (optional)</lable>
                        <div class="input-group">
                            <input type="number" name="age" class="form-control" value="<?php echo   $row['age']  ?>"
                                placeholder="Enter your Full name" min=5; id="age" onkeyup="checkage()">
                            <span id="age-err"> </span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn  mx-auto  R-btn"  id="submitbtncusUpdate" >Update</button>

                </form>
                <!--  -->
                <!-- <div class="col-xs-12">
                    <br>
                    <button class="btn btn-lg " id="submitbtncusUpdate" type="button"> Update <i
                            class="fa-light fa-badge-check"></i></button>
                </div> -->
            </div>

            <hr>


        </div>
        <!--/tab-pane-->
        <div class="tab-pane"id="settings">



        </div>
        <!--/col-9-->
    </div>
    <!--/row-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <!-- <script>
    $(document).ready(function() {

        $('#updatebtn').on('click', function() {

            $('#updatemodal').modal('show');

        });
    });
    </script> -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>





    <?php    

      
          include($tmpl .'footer.php') ;             //<!-- footer -->


  }
  
}else{ 
 header('location:index.php');   
}   


?>