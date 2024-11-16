<?php
session_start();
if (isset($_SESSION['usernameA'])) {
    $pageTitle = "Contact US";

    include("intil.php");

    if (isset($_SESSION['show_message_newForm'])) {
        echo "<script>alert('Your request has been sent successfully.');</script>";

         unset($_SESSION['show_message_newForm']); // Reset the session variable
     }
    ?>

    

<?php date_default_timezone_set('Asia/Bahrain'); ?>
<div class="container bg-form mt-3" style="min-height: 535px; width:50%">
    <div class="row justify-content-center">
        <div class="row">
            <h1 class="d-flex"> Contact form</h1>
        </div>

        <div class="col-md-12">


            <!-- action to the same page BY echo $_SERVER['PHP_SELF'] -->
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
                <div class="text-right">
                    <!-- <button class="btn btn-secondary" type="button"
                            onclick="window.location.href='cancel-page.php'">Cancel</button> -->
                    <button class="btn" type="submit">Submit</button>

                </div>
            </form>
        </div>
    </div>
</div>
</div>

<?php
    include($tmpl . 'footer.php'); //<!-- footer -->
} else {
    echo "You are unauthorized to enter this page.";
    header('location:index.php');
}
?>