<?php  
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
require("connection.php");
$pageTitle = "Items list";
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

<!-- Statrt Varifing POP UP FORM (MODAL) -->
<div class="modal fade" id="Vrimodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Admin Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="itemsBut.php" method="POST">

                    <div class="modal-body">

                    <input type="hidden" name="verItemId" id="verItemId">

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
<div class="modal fade" id="Blkmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Admin Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="itemsBut.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="blockItemId" id="blockItemId">

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

    <div class="container  table-responsive table-card">

    
        <h1>Items</h1> 

        <div class="main-content">
            <div class="loading-overlay" style="display: none;"><div class="overlay-content">Loading.....</div></div>
            
            <table class="table bg-white" id="itemTbl">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th> </th>
                    <th>Title</th>
                    <th>List date</th>
                    <th>Item_state</th>
                    <th>Price</th>
                    <th>Item_description</th>
                    <th>Quantity</th>
                    <th>Options</th>
                    
                  
                  </tr>
                  </thead>

                  <tbody id="post_list">

                  </tbody>

              </table>
            
            
              
        </div>
    </div>


  

</section>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


<script type="text/javascript">
    fetchData();

    /* Display items details */
    function fetchData() {
        var action = 'fetchData';
        $.ajax({
            url: "getData.php",
            method: "POST",
            data: {action:action},
            success: function(data){
                // alert(data);
                $('#post_list').html(data); 
            }
        });
    }

    /* operations on the items details */

        /* Active view item */
        $(document).on('click', '#actItem', function(){
        var id = $(this).attr('data-val');
        var action = 'actItem';
        $.ajax({
                    url: "getData.php",
                    method: "POST",
                    data: {action:action, id:id},
                    success: function(data){
                        alert("Item state has been changed successfully");
                        $('#post_list').html(data); 
                    }
                });
    });

        /* Make the item in Verifying state */
    $(document).on('click', '.verItem', function(){

      
      $('#Vrimodal').modal('show');
      event.preventDefault();

        var id = $(this).attr('data-val');
        var action = 'verItem';
        $('#verItemId').val(id);
        $.ajax({
                    url: "itemsBut.php",
                    method: "POST",
                    data: {action:action, id:id},
                    success: function(data){
                        //alert("Item state has been changed successfully");
                        $('#post_list').html(data); 
                    }
                });
    });

    /* Block the item */
    $(document).on('click', '.BlkItem', function(){

      $('#Blkmodal').modal('show');
      event.preventDefault();
        var id = $(this).attr('data-val');
        var action = 'BlkItem';
        $('#blockItemId').val(id);
        //alert(id);
        $.ajax({
                    url: "itemsBut.php",
                    method: "POST",
                    data: {action:action, id:id},
                    success: function(data){
                        //alert("Item state has been changed successfully");
                        //$('#post_list').html(data); 
                        
                    }
        });
    });
    $(document).ready(function(){
            
            $('#itemTbl').DataTable({
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

<script>

  

    </script>

<?php
        }
include($tmpl . 'footer.php'); //<!-- footer -->
?>

