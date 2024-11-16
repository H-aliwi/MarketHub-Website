<?php 

if(isset($_GET['shopID'])){
include('includes/functions/GetOwnerShopID.php');
include('includes/functions/getCategryName.php');

$shopId=$_GET['shopID'];
$Shop_owner_id=GetOwnerShopID($shopId);


require("connection.php");

$stat = $db->prepare("select * from shop_owner where Shop_OwnerID =? ");
$stat->execute(array($Shop_owner_id));
$rows = $stat->fetch();  // get all rows of data from DB
$count = $stat->rowCount();  // count the number of rows
if($count >0){
    $Username=$rows['Username'];
    $Email=$rows['Email'];

}

$stat_2 = $db->prepare("select * from shop where Shop_OwnerID =? ");
$stat_2->execute(array($Shop_owner_id));
$rows = $stat_2->fetch();  // get all rows of data from DB
$count_2 = $stat_2->rowCount();  // count the number of rows
if($count_2 >0){
    $shop_Name=$rows['shop_Name'];
    $shop_Description=$rows['shop_Description'];
    $payment_Information=$rows['payment_Information'];
    $shop_Logo=$rows['shop_Logo'];

}


$stat_3 = $db->prepare("select * from shop_category where shopID =?");
$stat_3->execute(array($_GET['shopID']));
$rows = $stat_3->fetchAll(PDO::FETCH_ASSOC);// get all rows of data from DB
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

.list-group-item.active {
    z-index: 2;
    color: #000;
    background-color: #Eaeaea;
    border-color: #Eaeaea;
}
</style>

<?php


// echo $Username;
// echo $Email;

// echo $shop_Name;
// echo $shop_Description;
// echo $payment_Information;
// echo $shop_Logo;

?>

<section class="dashboard">
<form  method="POST" id="shop-formUP" enctype="multipart/form-data">
        <div class="container bootstrap snippet mb-3 bg-white  " style="height: 700px;">
        <div id="message-up"></div>

            <h2 class=" mb-4 mt-4  p-3 font-weight-bold text-center">shop Detalis</h2>



            <div class="row mt-2 ">
                <div class="col-sm-3 mt-4 ">
                    <!--left col-->
                    <!-- logo -->
                    <div class="text-center">

                        <!--  -->
                        <img src="../shop_owner/layout/images/logo/<?php echo $shop_Logo ?>  " class="avatar img-circle img-thumbnail"
                            style="border-radius: 50%;" alt="avatar">
                            <div class="input-group">
                            <span id="logo-Err" style="margin-top: -310px;"> </span></div>

                    </div>

                   
                    </hr><br>

                    <!--Trade rejester  -->
                    <div class="mt-3 mb-5">
                        <div class="panel-body">
                            <div class="input-group">
                          
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
                                        id="username_shop" disabled>
                                    <span id="Username-Err"></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="inputPassword4">Email</label>
                                <div class="input-group">
                                    <input type="text" name='email' value="<?php echo $Email; ?>" class="form-control"
                                        id="Up_email_shop" disabled>
                                    <span id="email-Err"></span>
                                </div>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="col-sm-12 col-md-6">
                                <label for="inputEmail4">Shop name</label>
                                <div class="input-group">
                                    <input type="text" name='sname' value="<?php echo$shop_Name; ?>"
                                        class="form-control" id="upshop_name" disabled>
                                    <span id="Shop_name-Err"></span>
                                </div>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="col-sm-12 col-md-6 mt-3">
                                <label for="inputPassword4">Payment information</label>
                                <div class="input-group">
                                    <textarea class="form-control" name='pdscr' rows="4"
                                        id="up_Payment" disabled><?php echo $payment_Information;?></textarea>
                                    <span id="Payment-Err" style="margin-top: 30px;"></span>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-sm-12 col-md-6 mt-3">
                                <label for="inputPassword4">Shop description</label>
                                <div class="input-group">
                                    <textarea class="form-control" name='shopDsc' rows="4"
                                        id="up-des"  disabled><?php echo $shop_Description; ?></textarea>
                                    <span id="Shop_des-Err" ></span>
                                </div>
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




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
        include($tmpl . 'footer.php'); //<!-- footer -->
    }  ?>