<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
$pageTitle = "Genarate report";

    include("intil.php");  //<!-- router -->
    include("connection.php");


    ?> 
    <style>

        

.tabs-to-dropdown .nav-wrapper {
  padding: 15px;
  box-shadow: 0px 5px 10px rgb(26 12 12 / 22%);
}

.tabs-to-dropdown .nav-wrapper a {
  color:  #192a51;
}

.tabs-to-dropdown .nav-pills .nav-link.active {
  background-color:  #192a51;
}

.tabs-to-dropdown .nav-pills li:not(:last-child) {
  margin-right: 30px;
}

.tabs-to-dropdown .tab-content .container-fluid {
  max-width: 1250px;
  padding-top: 70px;
  padding-bottom: 70px;
}

.tabs-to-dropdown .dropdown-menu {
  border: none;
  box-shadow: 0px 5px 14px rgba(0, 0, 0, 0.08);
}

.tabs-to-dropdown .dropdown-item {
  padding: 14px 28px;
}

.tabs-to-dropdown .dropdown-item:active {
  color:  #f8f9fa;;
}

@media (min-width: 1280px) {
  .tabs-to-dropdown .nav-wrapper {
    padding: 15px 30px;
  }
}
.table-nowrap .table td, .table-nowrap .table th {
    white-space: nowrap;
}
.table>:not(caption)>*>* {
    padding: 0.75rem 1.25rem;
    border-bottom-width: 1px;
}
table th {
    font-weight: 600;
    background-color: #eeecfd !important;
    
    
}
.container-fluid tr{
  /* background-color:white; */
  border-bottom: 1px solid #ccc;


}
table tbody tr {
    border-bottom: 1px solid #ccc;
  }
/* table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px;
    background-color: white;} */


    .bg-form-sec{
        /* background-color: hwb(0 100% 0%); */
        width: 100%;
        height: 100%;
        margin: 20px auto;
        /* display: flex;
        justify-content: center; */
        padding: 30px;

        border: 1px solid #ccc;
        border-radius: 15px;
        /* background-color: #f9f9f9; */
    }
    


   
    </style>

    <section class="dashboard">
    <div class="tabs-to-dropdown">
  <div class="nav-wrapper d-flex align-items-center justify-content-between">
    <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pills-ordes-tab" data-toggle="pill" href="#pills-ordes" role="tab" aria-controls="pills-ordes" aria-selected="true">shop orders report</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-payments-tab" data-toggle="pill" href="#pills-payments" role="tab" aria-controls="pills-payments" aria-selected="false">shop payments report</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-items-tab" data-toggle="pill" href="#pills-items" role="tab" aria-controls="pills-items" aria-selected="false">shop sold items report</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-custmers-tab" data-toggle="pill" href="#pills-custmers-items" role="tab" aria-controls="pills-custmers-items" aria-selected="false">Customers</a>
      </li>
      <li class="nav-item " role="presentation">
        <a class="nav-link" id="pills-shop-tab" data-toggle="pill" href="#pills-shop" role="tab" aria-controls="pills-shop" aria-selected="false">Shop owners</a>
      </li>
      <li class="nav-item mt-2 ml-2" role="presentation">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact Form</a>
      </li>
    </ul>
  </div>

  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-ordes" role="tabpanel" aria-labelledby="pills-ordes-tab">
      <div class="container-fluid">
        <h2 class="mb-3 font-weight-bold">shop orders report</h2>
        <!-- content here -->
            <div class="container mt-5">
            
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fromDate">From:</label>
                            <input type="date" class="form-control" id="fromDate" name="fromDate" required >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="toDate">To:</label>
                            <input type="date" class="form-control" id="toDate" name="toDate" required >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="toDate">Shop ID:</label>
                            <input type="number" class="form-control" id="shopID_" name="shopID" required >
                        </div>
                    </div>
                    <div class="col-md-2 text-center" style="margin-top: 15px; display: flex; justify-content: flex-start; align-items: center;">
                        <button class="btn-o" type="submit" id="generateBtn">Generate</button>
                    </div>
                </div>
            <!-- Display the result -->
            <div id="resultTable"></div>
            
           </div>
        <!-- end here -->
      </div>
    </div>

    <div class="tab-pane fade" id="pills-payments" role="tabpanel" aria-labelledby="pills-payments-tab">
      <div class="container-fluid ">
        <h2 class="mb-3 font-weight-bold">shop payments report</h2>
         <!-- content start here -->
         <div class="container mt-5 ">
            
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fromDate_p">From:</label>
                        <input type="date" class="form-control" id="fromDate_p" name="fromDate_p" required >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="toDate_p">To:</label>
                        <input type="date" class="form-control" id="toDate_p" name="toDate_p"required >
                    </div>
                </div>
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="Shop ID">Shop ID:</label>
                            <input type="number" class="form-control" id="shopID_P" name="shopID_P" required >
                        </div>
                    </div>
                <div class="col-md-2 text-center" style="margin-top: 15px; display: flex; justify-content: flex-start; align-items: center;">
                    <button class="btn-o" type="submit" id="generateBtn__payment">Generate</button>
                </div>
            </div>
        <!-- Display the result -->
        <div id="resultTable_payment"></div>
        
       </div>
    <!-- end here -->

      </div>
    </div>

    <div class="tab-pane fade" id="pills-items" role="tabpanel" aria-labelledby="pills-items-tab">
      <div class="container-fluid">
        <h2 class="mb-3 font-weight-bold">shop sold items report</h2>
           <!-- content start here -->
           <div class="container mt-5">
            
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fromDate_items">From:</label>
                        <input type="date" class="form-control" id="fromDate_items" name="fromDate_items">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="toDate_items">To:</label>
                        <input type="date" class="form-control" id="toDate_items" name="toDate_items">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shopID_items">Shop ID:</label>
                        <input type="number" class="form-control" id="shopID_itemsG" name="shopID_itemsG">
                    </div>
                </div>
                <div class="col-md-2 text-center" style="margin-top: 15px; display: flex; justify-content: flex-start; align-items: center;">
                    <button class="btn-o" type="submit" id="generateBtn_items">Generate</button>
                </div>
            </div>
        <!-- Display the result -->
        <div id="resultTable_items"></div>
        
       </div>
    <!-- end here -->
    </div>
    </div>

    <!-- customrs -->
    <div class="tab-pane fade" id="pills-custmers-items" role="tabpanel" aria-labelledby="pills-custmers-tab">
      <div class="container-fluid ">
        <h2 class="mb-3 font-weight-bold">Customrts</h2>
         <!-- content start here -->
         <div class="container mt-5 ">
            
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fromDate_p">From:</label>
                        <input type="date" class="form-control" id="fromDate_p_cus" name="fromDate_p_cus">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="toDate_p">To:</label>
                        <input type="date" class="form-control" id="toDate_p_cus" name="toDate_p_cus">
                    </div>
                </div>
   
                <div class="col-md-4 text-center" style="margin-top: 15px; display: flex; justify-content: flex-start; align-items: center;">
                    <button class="btn-o" type="submit" id="generateBtn__cus">Generate</button>
                </div>
            </div>
        <!-- Display the result -->
        <div id="resultTable_cus"></div>
        
       </div>
    <!-- end here -->

      </div>
    </div>
    <!-- end -->


        <!-- shop owner -->
        <div class="tab-pane fade" id="pills-shop" role="tabpanel" aria-labelledby="pills-shop-tab">
      <div class="container-fluid ">
        <h2 class="mb-3 font-weight-bold">shop owners</h2>
         <!-- content start here -->
         <div class="container mt-5 ">
            
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fromDate_shop">From:</label>
                        <input type="date" class="form-control" id="fromDate_p_shop" name="fromDate_p_shop">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="toDate_shop">To:</label>
                        <input type="date" class="form-control" id="toDate_p_shop" name="toDate_p_shop">
                    </div>
                </div>
   
                <div class="col-md-4 text-center" style="margin-top: 15px; display: flex; justify-content: flex-start; align-items: center;">
                    <button class="btn-o" type="submit" id="generateBtn__shop">Generate</button>
                </div>
            </div>
        <!-- Display the result -->
        <div id="resultTable_shop"></div>
        
       </div>
    <!-- end here -->

      </div>
    </div>
    <!-- end -->


            <!-- Contact -->
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
      <div class="container-fluid ">
        <h2 class="mb-3 font-weight-bold">Contact form</h2>
         <!-- content start here -->
         <div class="container mt-5 ">
            
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fromDate_shop">From:</label>
                        <input type="date" class="form-control" id="fromDate_p_con" name="fromDate_p_con">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="toDate_shop">To:</label>
                        <input type="date" class="form-control" id="toDate_p_con" name="toDate_p_con">
                    </div>
                </div>
   
                <div class="col-md-4 text-center" style="margin-top: 15px; display: flex; justify-content: flex-start; align-items: center;">
                    <button class="btn-o" type="submit" id="generateBtn__con">Generate</button>
                </div>
            </div>
        <!-- Display the result -->
        <div id="resultTable_con"></div>
        
       </div>
    <!-- end here -->

      </div>
    </div>
    <!-- end -->


  </div>
</div>


    
    
    </section>

    <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
        // <!-- shop orders start -->

$(document).ready(function() {  
  
    // AJAX request when the generate button is clicked
    $('#generateBtn').click(function(e) {
        e.preventDefault();

        // Get the selected dates
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();
        var shopID = $('#shopID_').val();

        // AJAX request to fetch the data
        $.ajax({
            url: 'fetch_report_ordrsT.php', // Change 'fetch_report_ordrs.php' to the actual file name that will handle the AJAX request
            method: 'POST',
            data: {
                fromDate: fromDate,
                toDate: toDate,
                shopID:shopID

            },
            success: function(response) {
                // Display the fetched data in the resultTable div
                $('#resultTable').html(response);
                $('#orders').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                
            }
            
        });
       
    });

        // <!-- shop orders end -->
        



        // <!-- shop payments start -->

    // AJAX request when the generate button is clicked
    $('#generateBtn__payment').click(function(e) {
        e.preventDefault();

        // Get the selected dates
        var fromDate_p = $('#fromDate_p').val();
        var toDate_p = $('#toDate_p').val();
        var shopID_P = $('#shopID_P').val();
        

        // AJAX request to fetch the data
        $.ajax({
            url: 'fetch_report_paymentsT.php', // Change 'fetch_report_payments.php' to the actual file name that will handle the AJAX request
            method: 'POST',
            data: {
                fromDate_p: fromDate_p,
                toDate_p: toDate_p,
                shopID_P: shopID_P
            },
            success: function(response) {
                // Display the fetched data in the resultTable div
                $('#resultTable_payment').html(response);
                $('#orders_payment').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    });

        // <!-- shop payments end -->




        // <!--  shop items  start -->

    // AJAX request when the generate button is clicked
    $('#generateBtn_items').click(function(e) {
        e.preventDefault();

        // Get the selected dates
        var fromDate_items = $('#fromDate_items').val();
        var toDate_items = $('#toDate_items').val();
        var shopID_itemsG = $('#shopID_itemsG').val();



        // AJAX request to fetch the data
        $.ajax({
            url: 'fetch_report_itemsT.php', // Change 'fetch_report_payments.php' to the actual file name that will handle the AJAX request
            method: 'POST',
            data: {
                fromDate_items: fromDate_items,
                toDate_items: toDate_items,
                shopID_itemsG:shopID_itemsG
            },
            success: function(response) {
                // Display the fetched data in the resultTable div
                $('#resultTable_items').html(response);
                $('#items_sold').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    });// <!-- shop items end -->

    // 
            // <!-- customrts start-->

    // AJAX request when the generate button is clicked
    $('#generateBtn__cus').click(function(e) {
        e.preventDefault();

        // Get the selected dates
        var fromDate_p_cus = $('#fromDate_p_cus').val();
        var toDate_p_cus = $('#toDate_p_cus').val();



        // AJAX request to fetch the data
        $.ajax({
            url: 'fetch_report_customers.php', // Change 'fetch_report_payments.php' to the actual file name that will handle the AJAX request
            method: 'POST',
            data: {
                fromDate_p_cus: fromDate_p_cus,
                toDate_p_cus: toDate_p_cus,
            },
            success: function(response) {
                // Display the fetched data in the resultTable div
                $('#resultTable_cus').html(response);
                $('#customer_report').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    });// <!-- customrts end -->


       // <!-- shop owners start-->

    // AJAX request when the generate button is clicked
    $('#generateBtn__shop').click(function(e) {
        e.preventDefault();

        // Get the selected dates
        var fromDate_p_shop = $('#fromDate_p_shop').val();
        var toDate_p_shop = $('#toDate_p_shop').val();



        // AJAX request to fetch the data
        $.ajax({
            url: 'fetch_report_shopOwner.php', // Change 'fetch_report_payments.php' to the actual file name that will handle the AJAX request
            method: 'POST',
            data: {
                fromDate_p_shop: fromDate_p_shop,
                toDate_p_shop: toDate_p_shop,
            },
            success: function(response) {
                // Display the fetched data in the resultTable div
                $('#resultTable_shop').html(response);
                $('#shopOwner_report').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    });// <!-- shop owners end -->


           // <!-- contact start-->

    // AJAX request when the generate button is clicked
    $('#generateBtn__con').click(function(e) {
        e.preventDefault();

        // Get the selected dates
        var fromDate_p_con = $('#fromDate_p_con').val();
        var toDate_p_con = $('#toDate_p_con').val();



        // AJAX request to fetch the data
        $.ajax({
            url: 'fetch_report_contact.php', // Change 'fetch_report_payments.php' to the actual file name that will handle the AJAX request
            method: 'POST',
            data: {
                fromDate_p_con: fromDate_p_con,
                toDate_p_con: toDate_p_con,
            },
            success: function(response) {
                // Display the fetched data in the resultTable div
                $('#resultTable_con').html(response);
                $('#contact_report').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    });// <!-- contact end -->


    // 
});
        


        

</script>




    <?php
}
?>

    <script src="layout/js/Jqueryy.js" ></script>
        <!-- INCLUDE datatables for report -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <!-- INCLUDE datatables for report  end-->
    <script src="layout/js/JavaSceicts.js" ></script>
    <script src="layout/js/bootstrap.min.js" ></script>
    <!-- <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" ></script> -->
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js" ></script>

