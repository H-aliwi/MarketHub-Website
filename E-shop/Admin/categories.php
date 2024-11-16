<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
require("connection.php");
$pageTitle = "Categories list";

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
        <a class="nav-link active" id="pills-Category-tab" data-toggle="pill" href="#pills-Category" role="tab" aria-controls="pills-Category" aria-selected="true">Category</a>
        </li>
        <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-Sub_Category-tab" data-toggle="pill" href="#pills-Sub_Category" role="tab" aria-controls="pills-Sub_Category" aria-selected="false">Sub-Category</a>
        </li>
    </ul>
    </div>



  <!-- Start DELETE Category POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Category </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="CategoryData.php" method="POST">

                    <div class="modal-body">

                    <input type="hidden" name="del_id" id="del_id" value="">

                        <h6> Are you sure you want to delete this category?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                        <button type="submit" name="delCat" class="btn btn-danger delCat"> Delete </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

  <!-- End DELETE Category POP UP FORM (Bootstrap MODAL) -->

  
  <!-- Start DELETE Sub-Category POP UP FORM (Bootstrap MODAL) -->
  <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Sub-Category </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="SubCategoryData.php" method="POST">

                    <div class="modal-body">

                    <input type="hidden" name="del_ID" id="del_ID" value="">

                        <h6> Are you sure you want to delete this sub-category?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                        <button type="submit" name="delSubCat" class="btn btn-danger delSubCat"> Delete </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

  <!-- End DELETE Sub-Category POP UP FORM (Bootstrap MODAL) -->




    <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-Category" role="tabpanel" aria-labelledby="pills-Category-tab">
        <div class="container-fluid">
        <!-- <h2 class="mb-3 font-weight-bold">Category</h2> -->
        <!-- content here -->

          <?php 
            $query = $db->prepare("SELECT * FROM category ORDER BY Category_ID DESC");
            $query -> execute();
            $rows = $query->fetchAll();
            if(count($rows) > 0){
              $i = 0;
          
          ?>

            <table class="table bg-white" id="tableCat">
            <thead>
            <tr><th colspan="14"><div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Category table</h5>
                <a href="AddCat.php" class="btn btn-light btn-sm p-2"><i class="fa-sharp fa-solid fa-plus"></i>Add New Category</a>
                </div></th>
            </tr>
            <tr>
            <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Options</th>
            
            </tr>
            </thead>

            <tbody>

            <?php 
             foreach ($rows as $info){
              $i++;
            ?>
                <tr>
                    <td> <?php echo $i; ?></td>
                    <td> <b><?php echo $info['Category_name']; ?></b></td>
                    <td> <?php echo substr($info['Category_description'], 0, 40); ?>...</td>

                    <td>

                      <button type="button" class="btn btn-danger deletCat" data-val="<?php echo $info['Category_ID']; ?>">
                        <i class="fa-solid fa-trash"></i>
                      </button>

                      <a href="editCat.php?catID=<?php echo $info['Category_ID']; ?>" class="btn btn-secondary editCat">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>


                    </td>
                    
                    
                </tr>

            <?php 
             }
            }
            else{
              echo '<tr><td colspan="4"> No Data(s) found...</td></tr>';
            }
            ?>

            </tbody>

        </table>

        
        <!-- end here -->
        </div>
    </div>

    <div class="tab-pane fade" id="pills-Sub_Category" role="tabpanel" aria-labelledby="pills-Sub_Category-tab">
            <div class="container-fluid">
              <!-- <h2 class="mb-3 font-weight-bold">Sub-Category</h2> -->

              <!-- content start here -->
              
              <!-- <div class="container mt-4 table-responsive table-card"> -->

              <?php 
                $stmnt = $db->prepare("SELECT * FROM sub_category ORDER BY Sub_Category_ID DESC");
                $stmnt -> execute();
                $rows1 = $stmnt->fetchAll();
                if(count($rows1) > 0){
                  $j = 0;
          
              ?>

              <table class="table bg-white" id="tableSubCat">
                  <thead>
                  <tr><th colspan="14"><div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Sub Category table</h5>
                      <a href="AddSubCat.php" class="btn btn-light btn-sm p-2"><i class="fa-sharp fa-solid fa-plus"></i>Add New Sub-Category</a>
                      </div></th>
                  </tr>
                  <tr>
                  <tr>
                  <th>#</th>
                  <th>Sub Category Name</th>
                  <th>Sub Category Description</th>
                  <th>Options</th>
                  

                  </tr>
                  </thead>

                  <tbody>
                    <?php 
                      foreach ($rows1 as $info1){
                        $j++;
                      ?>
                          <tr>
                              <td> <?php echo $j; ?></td>
                              <td> <b><?php echo $info1['Sub_Category_name']; ?></b></td>
                              <td> <?php echo substr($info1['Sub_Category_description'], 0, 40); ?>...</td>

                              <td>

                              <button type="button" class="btn btn-danger deletSubCat" subData_val="<?php echo $info1['Sub_Category_ID']; ?>">
                                <i class="fa-solid fa-trash"></i>
                              </button>

                              <a href="editSubCat.php?subcatID=<?php echo $info1['Sub_Category_ID']; ?>" class="btn btn-secondary editSubCat">
                                <i class="fa-solid fa-pen-to-square"></i>
                              </a>

                              </td>
                              
                              
                          </tr>

                      <?php 
                      }
                      }
                      else{
                        echo '<tr><td colspan="4"> No Data(s) found...</td></tr>';
                      }
                      ?>

                  </tbody>

              </table>
        </div>
            
              <!-- end here -->

            </div>
          </div>

        </div>
      </div>

</section>


  <script>

  
          $(document).ready(function(){
            
          $('#tableCat').DataTable({
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

            $('#tableSubCat').DataTable({
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
        


          $(document).on('click', '.deletCat', function(){

            var catID = $(this).data('val');
            //alert (catID);
            $('#del_id').val(catID);
            $('#deletemodal').modal('show');

          });

          $(document).on('click', '.deletSubCat', function(){

            var subcatID = $(this).attr('subData_val');
            //alert(subcatID);
            $('#del_ID').val(subcatID);
            $('#delModal').modal('show');

          });

  </script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
}
        include($tmpl . 'footer.php'); //<!-- footer -->
    ?>