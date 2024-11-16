<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
require("connection.php");
$pageTitle = "Shops payment list";

include("intil.php");  //<!-- router -->


?>
<style>
    
    .avatar.sm {
        width: 2.25rem;
        height: 2.25rem;
        font-size: .818125rem;
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
    .fa-plus:before {
        content: "\f067";
        margin-right: 4px;
    }
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
    box-shadow: 0px 5px 10px rgb(26 12 12 / 22%);
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
tr{
  background-color:white;

}
    </style>

    <section class="dashboard">

      <div class="tabs-to-dropdown">

        <div class="nav-wrapper d-flex align-items-center justify-content-between">
          <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="pills-Paid-tab" data-toggle="pill" href="#pills-Paid" role="tab" aria-controls="pills-Paid" aria-selected="true">UnPaid payment</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-UnPaid-tab" data-toggle="pill" href="#pills-UnPaid" role="tab" aria-controls="pills-UnPaid" aria-selected="false">Paid payment</a>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-Paid" role="tabpanel" aria-labelledby="pills-Paid-tab">
            <div class="container-fluid">
              <h2 class="mb-3 font-weight-bold">UnPaid page</h2>
              <!-- content here -->
                <table class="table bg-white" id="ShopPyTbl">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Shop Name</th>
                    <th>Is Paid</th>
                    <th>Sales amount</th>
                    <th>Interest rate</th>
                    <th>Amount after deducting</th>
                    <th>Options</th>
                  
                  </tr>
                  </thead>

                  <tbody id="post_list">

                  </tbody>

              </table>

              
              <!-- end here -->
            </div>
          </div>

          <div class="tab-pane fade" id="pills-UnPaid" role="tabpanel" aria-labelledby="pills-UnPaid-tab">
            <div class="container-fluid">
              <h2 class="mb-3 font-weight-bold">Paid page</h2>
              <!-- content start here -->
              <div class="container mt-4 table-responsive table-card">

              <table class="table bg-white" id="ShopNotPyTbl">
                  <thead>
                  <tr>
                  <th>#</th>
                    <th>Shop Name</th>
                    <th>Paid Admin</th>
                    <th>Is Paid</th>
                    <th>Paid date</th>
                    <th>Sales amount</th>
                    <th>Interest rate</th>
                    <th>Amount after deducting</th>

                  </tr>
                  </thead>

                  <tbody id="post_list1">

                  </tbody>

              </table>
        </div>
            
              <!-- end here -->

            </div>
          </div>

        </div>
      </div>

      
  </section>



<script type="text/javascript">
    fetchData();
    fetchData1();

    /* Display items details */
    function fetchData() {
        var action = 'fetchData';
        $.ajax({
            url: "shopPayData.php",
            method: "POST",
            data: {action:action},
            success: function(data){
                // alert(data);
                $('#post_list').html(data); 
            }
        });
    }

    /* shop payment done */
    $(document).on('click', '#Paid', function(){
        var id = $(this).attr('data-val');
        var action = 'ShPaid';
        $.ajax({
                    url: "shopPayData.php",
                    method: "POST",
                    data: {action:action, id:id},
                    success: function(data){
                        //alert("Item state has been changed successfully");
                        $('#post_list').html(data); 
                    }
                });
    });

    /* Display items details */
    function fetchData1() {
        var action = 'fetchData1';
        $.ajax({
            url: "shopUnPaidData.php",
            method: "POST",
            data: {action:action},
            success: function(data){
                // alert(data);
                $('#post_list1').html(data); 
            }
        });
    }

    


</script>   


<script>
  
          $(document).ready(function(){
            
          $('#ShopPyTbl').DataTable({
              "pagingType":"full_numbers",
              "lengthMenu":[
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
              ],
              responsive: true,
              language:{
                search: "_INPUT_",
                searchPlaceholder:"Search",
                }
            });
          });

          $(document).ready(function(){
            
            $('#ShopNotPyTbl').DataTable({
                "pagingType":"full_numbers",
                "lengthMenu":[
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
                ],
                responsive: true,
                language:{
                  search: "_INPUT_",
                  searchPlaceholder:"Search",
                  }
              });
            });

</script>        

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
}
        include($tmpl . 'footer.php'); //<!-- footer -->
    ?>