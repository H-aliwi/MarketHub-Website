<?php
session_start();
include('includes/functions/showMessageBoxShop.php');
include('includes/functions/showMessageBoxCustomer.php');


$NoNavbar ="";  // if this var exsit it will not add navbar to this page.
$pageTitle = "Login Page";
$NoFooter ="";


?>
<?php   include("intil.php"); 

// if _SERVER REQUEST_METHOD is post

if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // get user information and store in var
        $username =$_POST['user'];
        $password =$_POST['pass'];
        $hashpass =   sha1($password);   //hash the pass
        //check if user(customer) in DB
        // prepare()  do some statement befor enter DB
        //? that come from form 
        $stat =  $con->prepare(
        "select * from customer where  
        Username= ? AND  
        Password =?;");                             
        $stat->execute(array($username, $hashpass));
        $row_=$stat->fetch();     // get Data from DB
        $count= $stat->rowCount();  // if user is exesis it will count  1  and it is admin GroupID=1
        //check if user(shop_owner) in DB

        $stat_2 =  $con->prepare("
        select * from shop_owner where  
        Username= ? AND  
        Password =?;");
                                    
        $stat_2->execute(array($username, $hashpass));
        $row_2=$stat_2->fetch();     // get Data from DB
        $count_2= $stat_2->rowCount();  // if user is exesis it will count  1  and it is admin GroupID=1

        //check if Admin in DB

        $stat_3 =  $con->prepare("
        select * from admin where  
        Username= ? AND  
        Password =?;");
                                    
        $stat_3->execute(array($username, $hashpass));
        $row_3=$stat_3->fetch();     // get Data from DB
        $count_3= $stat_3->rowCount();  // if user is exesis it will count  1  and it is admin GroupID=1

        //  end check





        if ($count  > 0)    // user (customer exsit) 
        {    
            //check customer state
            $Customer_state=$row_['Customer_state'];
            if($Customer_state=="Active"){
                 // I will record session if  customer is exist in DB and is Active
            $_SESSION['usernameA'] =$username;     //record session  username of login customer
            $_SESSION['UserID'] =$row_['CustomerID'];       //record session  UserID of login customer


            }
            elseif($Customer_state=="Verifying")
            {    
                echo '<div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong> Info!</strong>' .' '.$row_['Admin_feedback'].'.
                      </div>';
            }

            else {  // show admin feedback for Blocked
                echo '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong> Danger!</strong>' .' '.$row_['Admin_feedback'].'.
                      </div>';

            }
           
        }

        elseif ($count_2  > 0) {   // user (shop_owner exsit) 


            $Shop_owner_state=$row_2['Shop_owner_state'];
            if($Shop_owner_state =="Active"){
                 // I will record session if  Shop owner is exist in DB and is Active
            $_SESSION['username_shop_owner'] =$username;     //record session  username of login Shop owner. 
            $_SESSION['shop_onwer_id'] =$row_2['Shop_OwnerID'];       //record session  UserID of login Shop owner.


            }
            elseif($Shop_owner_state=="Verifying")

            {   
                echo '<div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong> Info!</strong>' .' '.$row_2['admin_feedback'].'.
                      </div>';
            }

            else {  // show admin feedback for Blocked
                echo '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong> Danger!</strong>' .' '.$row_2['admin_feedback']. '.
                      </div>';

            }        
           
        }

        elseif ($count_3 > 0){

            $_SESSION['username_admin'] =$username;     //record session  username of login Shop owner. 
            $_SESSION['adminID'] =$row_3['adminID'];       //record session  UserID of login Shop owner.
            
        }

        else{
        // echo "Not a cutomer or shop owner.";
              echo '<div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> Invalid uesrname or password.
                  </div>';

        }

}

if(isset($_SESSION['usernameA'])){
    header('location:control_page.php'); //Redirect to Customer home page
    exit();
}

if(isset($_SESSION['username_shop_owner'])){
    header('location:../shop_owner/shop_home.php'); //Redirect to Shop owner home page
    exit();
}

if(isset($_SESSION['username_admin'])){
    header('location:../Admin/Admin_home.php'); //Redirect to Admin home page
    exit();
}

?>

<style>
#message-box-shop,
#message-box-cus {
  width: 525px;
  height: 265px;
  padding: 20px;
  background-color: #fff;
  border-radius: 29px;
  text-align: center;
  z-index: 9999;
  position: absolute;
  left: 417px;
  top: 10px;
}

.fa-check-circle:before,
.fa-circle-check:before {
  content: "\f058";
  font-size: 60px;
}

.hidden-shop,
.hidden-cus {
  display: none;
}
</style>
<div id="message-box-shop" class="hidden-shop">
  <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
  <h2 style="padding-top: 12px">SUCCESS!</h2>
  <p style="color: #808080;">Your request to open shop has been sent successfully. You will be able to login to the shop
    owner dashboard once the request is accepted.</p>
  <button onclick="closeMessageBoxShop()"
    style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
</div>
<div id="message-box-cus" class="hidden-cus">
  <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
  <h2 style="padding-top: 12px">SUCCESS!</h2>
  <p style="color: #808080;">Successful registration. Welcome to our community! Login now.</p>
  <button onclick="closeMessageBoxCustomer()"
    style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
</div>
<?php

        // if(isset($_SESSION['show_message_newShop']))
        // {    
        //     echo '<div class="alert alert-warning">
        //          <button type="button" class="close" data-dismiss="alert">&times;</button>
        //            <strong>Warning!</strong> New shop request send.
        //              </div>';
        //     // showMessageBox(); 
        //     unset($_SESSION['show_message_newShop']); // Reset the session variable

        // }

        if (isset($_GET['message'])) {
            // $message = $_GET['message'];
            //           echo '<div class="alert alert-success">
            //      <button type="button" class="close" data-dismiss="alert">&times;</button>
            //        <strong>Success! </strong> The request to open shop has been sent successfully. You will be able to login to the shop owner dashboard once the request is accepted.
            //          </div>';

                     showMessageBoxShop();
        }
        if (isset($_GET['message_new_customer'])) {
            // $message = $_GET['message'];
            //           echo '<div class="alert alert-success">
            //      <button type="button" class="close" data-dismiss="alert">&times;</button>
            //        <strong>Success! </strong> The request to open shop has been sent successfully. You will be able to login to the shop owner dashboard once the request is accepted.
            //          </div>';

                     showMessageBoxCustomer();
        }

        



    ?>
<div class="bg-form" style="    min-height: 450px;">


  <!-- action to same page  BY echo $_SERVER['PHP_SELF']  -->
  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h2>Welcome back! </h2>
    <span class="icoin"> <i class="fa-solid fa-user fa-2xl"></i></span>
    <h6>Login to your account</h6>
    <input class="form-control  form-control-md" type="text" name='user' placeholder="Username" autocomplete="OFF"
      required />
    <input class="form-control  form-control-md" type="password" name="pass" placeholder="Password"
      autocomplete="new-passwprd" required />

    <input class="btn  btn-block " type="submit" value="Login" />
    <div class="pass-fogrget" style="float: right;
        margin-right: 7px;">
      <a href="../email-conf.php">
        <h6 style="color:blue; ">Forget password ?</h6>
      </a>
    </div>

    <hr style="margin-top: 2rem;">
    <h6>New user? <a href="Control_Register.php">
        <h6 style="color:blue; ">Register now</h6>
      </a></h6>

  </form>
</div>





<?php   include($tmpl .'footer.php')  ?>
<!-- footer -->