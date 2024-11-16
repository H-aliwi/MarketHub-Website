<?php 
session_start();
if (isset($_SESSION['shop_onwer_id'])) {

    $pageTitle = "Contact US";

    if (isset($_SESSION['show_message_newForm'])) {
        echo "<script>alert('Your request has been sent successfully.');</script>";

         unset($_SESSION['show_message_newForm']); // Reset the session variable
     }
    include("intil.php");  //<!-- router -->
    include('includes/functions/getShopID.php');

    include("connection.php");
    $ownerId = $_SESSION['shop_onwer_id'];
    $shopID = getShopID($ownerId);
    ?> 
    <style>
        .bg-form{
    background-color: hwb(0 100% 0%);
    width: 100%;
    height: 96%;
    margin: 20px auto;
    /* display: flex;
    justify-content: center; */
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 15px;
    /* background-color: #f9f9f9; */
    
}
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
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

    </style>
    <section class="dashboard">

    <?php date_default_timezone_set('Asia/Bahrain'); ?>
<div class="container bg-form mt-3" style="min-height: 535px; width:50%">
    <div class="row justify-content-center">
        <div class="row">
            <h1 class="d-flex"> Contact form</h1>
        </div>

        <div class="col-md-12">


            <form method="post" action="ContactFormProcess.php" style="width: -webkit-fill-available;">
                <div class="form-group">
                    <label for="CName">Name</label>
                    <input type="text" class="form-control col-12" name="CName" id="CName" required>
                </div>
                <div class="form-group">
                    <label for="CEmail">Email</label>
                    <input type="email" class="form-control col-12" name="CEmail" id="CEmail" required>
                </div>
                <div class="form-group">
                    <label for="CTitle">Title</label>
                    <input type="text" class="form-control col-12" name="CTitle" id="CTitle" required>
                </div>
                <div class="form-group">
                    <label for="CDescription">Description</label>
                    <textarea class="form-control col-12" name="CDescription" id="CDescription" required></textarea>
                </div>
                <input type="hidden" name="CTime" id="CTime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                <input type="hidden" name="CReplay" id="CReplay">
             
                <button class="btn" type="submit">Submit</button>

            </form>
        </div>
    </div>
</div>
</div>
    
    
    </section>

    <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    

</script>

    <?php
    include($tmpl . 'footer.php'); //<!-- footer -->
} else {
    echo "You are not authorized to enter this page";
    header('location:../Users/index.php'); 
}
?>