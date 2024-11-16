<?php
session_start();
if (isset($_SESSION['usernameA'])) {
    $pageTitle = "FAQs";
    include("intil.php");
?>
<style>
    .card-header p{
        color: #192a51;

    }
</style>

<?php date_default_timezone_set('Asia/Bahrain'); ?>
<div class="container bg-form mt-2" style="height: 540px; max-height: 1000px; width: 60%">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container" style="padding: 30px;" id='target-FAQs'>
                <h2 style="font-size: 28px;" class="mx-auto">Frequently Asked Questions</h2>
                <div id="accordion" style="max-height: 100%; overflow-y: auto;">
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link" data-toggle="collapse" href="#collapse1">
                                <p>Question 1: How can I open a shop on the MarketHub website? </p>
                            </a>
                        </div>
                        <div id="collapse1" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                Answer 1:<br>
                                1. Visit the MarketHub website and send a request to open a shop.<br><br>
                                2. Fill in the necessary details, such as your shop name, description, payment
                                preferences, and what you want to sell. Submit the form to open your shop.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link" data-toggle="collapse" href="#collapse2">
                                <p>Question 2: After shop approval, what features are available in MarketHub's shop
                                    owner dashboard?
                                </p>
                            </a>
                        </div>
                        <div id="collapse2" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                Answer 2: Once your shop request is accepted and you log in to your shop owner dashboard
                                on MarketHub, you will have access to various features and options, like Add Items,
                                Generate Reports, and others.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link" data-toggle="collapse" href="#collapse3">
                                <p>Question 3: Are there any fees associated with listing items on MarketHub?
                                </p>
                            </a>
                        </div>
                        <div id="collapse3" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                Answer 3: MarketHub takes a 4% fee only on shop sold items.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <!-- <div class="card-header">
                          <a class="card-link" data-toggle="collapse" href="#collapse4">
                            Question 4
                          </a>
                        </div> -->
                        <div id="collapse4" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                Answer 4
                            </div>
                        </div>
                    </div>
                </div>
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