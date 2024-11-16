<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
require("connection.php");
$pageTitle = "Users list";

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
              <a class="nav-link active" id="pills-Customer-tab" data-toggle="pill" href="#pills-Customer" role="tab" aria-controls="pills-Customer" aria-selected="true">Customer</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-Shop_owner-tab" data-toggle="pill" href="#pills-Shop_owner" role="tab" aria-controls="pills-Shop_owner" aria-selected="false">Shop owner</a>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-Customer" role="tabpanel" aria-labelledby="pills-Customer-tab">
            <div class="container-fluid">
              <h2 class="mb-3 font-weight-bold">Customer</h2>
              <!-- content here -->
              <div class="container mt-4 table-responsive table-card">

              
<!-- Statrt Varifing POP UP FORM (MODAL) -->
<div class="modal fade" id="VriCus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Admin Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="CustomerBut.php" method="POST">

                    <div class="modal-body">

                    <input type="hidden" name="verCusId" id="verCusId">

                        <div class="form-group">
                            <label> Admin Feedback </label>
                            <input type="textbox" name="VrAdFeedback" id="VrAdFeedback" class="form-control">
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updateVer" class="btn btn-warning">Verifying</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </div> 
<!-- End Varifing POP UP FORM (MODAL) -->

<!-- Statrt Block POP UP FORM (MODAL) -->
<div class="modal fade" id="BlkCus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Admin Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="CustomerBut.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="blockCusId" id="blockCusId">

                        <div class="form-group">
                            <label> Admin Feedback </label>
                            <input type="textbox" name="BlkAdFeedback" class="form-control">
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updateblock" class="btn btn-danger">Block</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </div>
<!-- End Block POP UP FORM (MODAL) -->


                <table class="table bg-white" id="tableCU">
                  <thead>
                  <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>FullName</th>
                  <th>Gender</th>
                  <th>Age</th>
                  <th>User State</th>
                  <th>Admin Feedback</th>
                  <th>Options</th>
                  
                  </tr>
                  </thead>

                  <tbody id="usersCU">

                  </tbody>

              </table>

              
              <!-- end here -->
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="pills-Shop_owner" role="tabpanel" aria-labelledby="pills-Shop_owner-tab">
            <div class="container-fluid">
              <h2 class="mb-3 font-weight-bold">Shop owner</h2>
              <!-- content start here -->
              <div class="container mt-4 table-responsive table-card">

              
<!-- Statrt Varifing POP UP FORM (MODAL) -->
<div class="modal fade" id="Vrishop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Admin Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="OShopBut.php" method="POST">

                    <div class="modal-body">

                    <input type="hidden" name="verShopId" id="verShopId">

                        <div class="form-group">
                            <label> Admin Feedback </label>
                            <input type="textbox" name="VrAdFeedback" id="VrAdFeedback" class="form-control">
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updateVer" class="btn btn-warning">Verifying</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </div> 
<!-- End Varifing POP UP FORM (MODAL) -->

<!-- Statrt Block POP UP FORM (MODAL) -->
<div class="modal fade" id="Blkshop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Admin Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="OShopBut.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="blockOShopId" id="blockOShopId">

                        <div class="form-group">
                            <label> Admin Feedback </label>
                            <input type="textbox" name="BlkAdFeedback" class="form-control">
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updateblock" class="btn btn-danger">Block</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </div>
<!-- End Block POP UP FORM (MODAL) -->

              <table class="table bg-white" id="tableOS">
                  <thead>
                  <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>User State</th>
                  <th>Admin Feedback</th>
                  <th>Admin Name</th>
                  <th>Options</th>

                  </tr>
                  </thead>

                  <tbody id="usersOS">

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

          
          // Start of the customer part


          /* Display customers details */
          function fetchData1() {
              var action1 = 'fetchData1';
              $.ajax({
                  url: "usersData.php",
                  method: "POST",
                  data: {action1:action1},
                  success: function(data){
                      // alert(data);
                      $('#usersCU').html(data); 
                  }
              });
          }

             /* make the customer in Active state */
        $(document).on('click', '#actCus', function(){
        var Cusid = $(this).attr('data-val');
        var action1 = 'actCus';
        $.ajax({
                    url: "usersData.php",
                    method: "POST",
                    data: {action1:action1, Cusid:Cusid},
                    success: function(data){
                        alert("user state has been changed successfully");
                        $('#usersCU').html(data); 
                    }
                });
        });

        /* Make the customer state Verifying */
        $(document).on('click', '.verCus', function(){
        $('#VriCus').modal('show');
        event.preventDefault();

          var Cusid = $(this).attr('data-val');
          var action1 = 'veruser';
          $('#verCusId').val(Cusid);
        });


        /* Block the customer */
        $(document).on('click', '.BlkCus', function(){

        $('#BlkCus').modal('show');
        event.preventDefault();
          var Cusid = $(this).attr('data-val');
          var action1 = 'BlkCus';
          $('#blockCusId').val(Cusid);
          //alert(id);
        });


        // End of the customer part

         
          


          // Start of the owner shop part

         /* Display Owner shop details */
         function fetchData() {
              var action = 'fetchData';
              $.ajax({
                  url: "usersData.php",
                  method: "POST",
                  data: {action:action},
                  success: function(data){
                      // alert(data);
                      $('#usersOS').html(data); 
                  }
              });
          }

          /* Active view Owner shop */
        $(document).on('click', '#actuser', function(){
        var id = $(this).attr('data-val');
        var action = 'actuser';
        $.ajax({
                    url: "usersData.php",
                    method: "POST",
                    data: {action:action, id:id},
                    success: function(data){
                        alert("user state has been changed successfully");
                        $('#usersOS').html(data); 
                    }
                });
    });

        /* Make the owner shop state Verifying */
          $(document).on('click', '.veruser', function(){

      
          $('#Vrishop').modal('show');
          event.preventDefault();

            var id = $(this).attr('data-val');
            var action = 'veruser';
            $('#verShopId').val(id);
            
          });


          
    /* Block the owner shop */
    $(document).on('click', '.Blkuser', function(){

        $('#Blkshop').modal('show');
        event.preventDefault();
          var id = $(this).attr('data-val');
          var action = 'Blkuser';
          $('#blockOShopId').val(id);
          //alert(id);
          
        });

        // End of the owner shop part

        

        </script>

        <script>
          $(document).ready(function(){
            
          $('#tableCU').DataTable({
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

          $('#tableOS').DataTable({
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