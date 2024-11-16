<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
require("connection.php");
$pageTitle = "Shop list";
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

<div class="container table-responsive table-card">
        <h1>Shops</h1> 

        <hr>

        <div class="main-content">
            <div class="loading-overlay" style="display: none;"><div class="overlay-content">Loading.....</div></div>
            
            
            <table class="table bg-white mr-3" id="shopsTbl">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>Shop name</th>
                        <th>Shop description</th>
                        <th>Payment information</th>
                        <th>rate</th>
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
        var action1 = 'fetchData';
        $.ajax({
            url: "getData.php",
            method: "POST",
            data: {action1:action1},
            success: function(data){
                // alert(data);
                $('#post_list').html(data); 
            }
        });
    }
    </script>

<script>
        $(document).ready(function(){
            
          $('#shopsTbl').DataTable({
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

<?php
}
include($tmpl . 'footer.php'); //<!-- footer -->
?>
