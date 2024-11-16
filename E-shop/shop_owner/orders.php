<?php     
session_start();
$pageTitle = "Shop Orders";

if (isset($_SESSION['shop_onwer_id']) ) 
{
 include("intil.php");  //<!-- router -->
  include('includes/functions/getShopID.php');
  include('includes/functions/showMessageBox.php');
  include('includes/functions/showMessageBoxD.php');

  include("connection.php");
  $ownerId = $_SESSION['shop_onwer_id'];
  $shopID = getShopID($ownerId);
 // SQL statment
  $stat = $con->prepare("SELECT ord.Order_ID, s.shopID, c.CustomerID, c.fullname, ord.Admin_note, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date, SUM(i.Price * od.quantity) AS Total_Price
  FROM shop s
  INNER JOIN item i ON s.shopID = i.shopID
  INNER JOIN order_detalis od ON i.ItemID = od.ItemID
  INNER JOIN orders ord ON ord.Order_ID = od.Order_ID
  INNER JOIN shop_order so ON s.shopID = so.shopID AND so.Order_ID = ord.Order_ID
  INNER JOIN customer c ON c.CustomerID = ord.CustomerID
  WHERE s.shopID = '$shopID'
  GROUP BY ord.Order_ID, s.shopID, c.CustomerID, c.fullname, ord.Admin_note, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date;");
 //  execute SQL statment

  $stat->execute();
?>


<style>
            .table-nowrap .table td, .table-nowrap .table th {
          white-space: nowrap;
      }
      .table>:not(caption)>*>* {
          padding: 0.75rem 1.25rem;
          border-bottom-width: 1px;
      }
      table th {
          font-weight: 600;
          background-color: #eeecfd ;
            /* background-color: #192a51;
          color: white; */
          
      }
      tr{
        background-color:white;
      }
        .bg-form-sec{
        background-color: hwb(0 100% 0%);
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
    .fa-add:before, .fa-plus:before {
    content: "\2b";
    color: white;
    margin-right: 15px;


}
.fa-trash-alt:before, .fa-trash-can:before {
    content: "\f2ed";
 
    color: white;
}
.fa-edit:before, .fa-pen-to-square:before {
    content: "\f044";
    color: white;
}

/* message */

#message-box,#message-box-d,#message-box-del {
    width: 450px;
    height: 212px;
    padding: 20px;
    background-color: #fff;
    border-radius: 29px;
    text-align: center;
    z-index: 9999;
    position: absolute;
    left: 340px;
    top: 100px;
}


.hidden-m ,.hidden-m-d ,.hidden-m-del{
  display: none;
}


.fa-check-circle:before, .fa-circle-check:before {
    content: "\f058";
    font-size: 50px;
}
.fa-magnifying-glass:before, .fa-search:before {
    content: "\f002";
    color: white;
}

/* message end */


    </style>

<section class="dashboard ">
    <!-- <div class="mt-4 mb-4 text-center"><h2 class="mb-3 font-weight-bold">shop items</h2></div> -->
    <!-- update -->
    <div id="message-box" class="hidden-m">
    <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
          <h2>SUCCESS!</h2>
      <p style="color: #808080;">Item details have been updated successfully.</p>
      <button onclick="closeMessageBox()" style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
    </div>
<!-- add -->
    <div id="message-box-d" class="hidden-m-d">
    <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
          <h2>SUCCESS!</h2>
      <p style="color: #808080;">Item have been added successfully.</p>
      <button onclick="closeMessageBox()" style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
    </div>
    <!-- delete -->
    <div id="message-box-del" class="hidden-m-del">
    <i class="fa-regular fa-circle-check" style="color: #37e143;"></i>
          <h2>SUCCESS!</h2>
      <p style="color: #808080;">Item have been delete successfully.</p>
      <button onclick="closeMessageBox()" style=" padding: 5px 16px;background-color: #4CAF50;color: white;border: none;border-radius: 10px;cursor: pointer;">Ok</button>
    </div>
    <?php

    //  delete seccss
 if (isset($_SESSION['show_message_add'])) {
    showMessageBoxadd();
     unset($_SESSION['show_message_add']); // Reset the session variable
 }

  if (isset($_SESSION['show_message'])) {
    showMessageBox();
     unset($_SESSION['show_message']); // Reset the session variable
 }

 if (isset($_SESSION['show_message_del'])) {
    showMessageBox();
     unset($_SESSION['show_message_del']); // Reset the session variable
 }
 

?>
<div class="container bg-form-sec table-responsive">

<?php
        if (isset($_GET['message'])) {
            // $message = $_GET['message'];
            //           echo '<div class="alert alert-success">
            //      <button type="button" class="close" data-dismiss="alert">&times;</button>
            //        <strong>Success! </strong> The request to open shop has been sent successfully. You will be able to login to the shop owner dashboard once the request is accepted.
            //          </div>';

            showMessageBoxadd();
        }

?>
    
        <table id="Table-ordrs" class="display" style="width:100%">
        
            <thead>
                <tr><th colspan="14"><div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Orders table</h5>
                </div></th></tr>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Total price</th>
                    <th>Is Delivered</th>
                    <th>Delivered date</th>
                    <th>Admin note</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

            <?php

            // Display messages
    if ($stat->rowCount() > 0) {
      while ($row = $stat->fetch()) {

        echo '
        <tr>
        <td>'.$row['Order_ID'].'</td>
        <td>'.$row['Order_date'].'</td>
        <td>'.$row['fullname'].'</td>
        <td>'.$row['Total_Price'].'</td>
        <td>'.$row['IsDelivered'].'</td>
        <td>'.$row['Delivered_date'].'</td>
        <td>'.$row['Admin_note'].'</td>
        <td   style="display: inline-flex;">    
                <a href="order_details.php?orderID='.$row['Order_ID'].'"> 
                <button type="submit" class="btn editebtn" 
                style="padding: 5px;display: flex;border-radius: 10%;justify-content: center;align-items: center;">
                <i class="fa-solid fa-magnifying-glass"></i>
                  </button> 
                </a>
                   
       </td>



     
        </tr>';
              
      }}?> 
<!-- <a  class="btn-danger" href="" > edit</a><a class="btn updatebtn" href=""> delete</a>   -->
            </tbody>
            <tfoot>
                <tr>
                    <!-- <th>Item ID</th>
                    <th>Category ID</th>
                    <th>Sub Category ID</th>
                    <th>shop ID</th>
                    <th>List date</th>
                    <th>Item_state</th>
                    <th>Item Title</th>
                    <th>Item_description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount Percent</th>
                    <th>Item image</th>
                    <th>Admin feedback</th>
                    <th>action</th> -->

                </tr>
            </tfoot>
        </table>


     </div>
    

</section>


<!--  header-->

<!--  Navbar-->


    <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"style="
                                                                        font-family: inherit;
                                                                        font-weight: inherit;
                                                                    ">Delete item  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="delete_item.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="item_id" id="item_id"> <!-- pass item_id -->

                        <h5 style="display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            color: rgb(96 100 105);
                                            font-size: 18px;
                                            font-style: initial;
                                            font-weight: 300;"> 
                                            Are you sure you want to delete item?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal"
                        style="padding: 4.5px; border-radius: 8%;"> Cancel </button>
                        <button type="submit" name="delete_item" class="btn-danger 
                        "style="
                            padding: 4.5px;
                            border-radius:8px;
                        "> Delete </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script>

        $(document).ready(function () {

            //    stert toggle-button "for close nav"
                $(".toggle-button").click(function() {
            $("nav").toggleClass("close");
            $(this).toggleClass('clicked');

             });
            //  end toggle-button


            // start delete prosses
        
                $('.deletebtn').on('click', function () {
                $('#deletemodal').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#item_id').val(data[0]);// pass data[0] which is ItemID to deletemodal


            });
            // end delete prosses
        });
    
                new DataTable('#Table-ordrs');

        
    </script>



    <script src="layout/js/Jqueryy.js" ></script>
    <!-- <script src="layout/js/backendd.js" ></script> -->
    <script>
        const activePage = window.location.pathname;
        const navLinks = document.querySelectorAll('nav a');

        Array.from(navLinks).forEach((link) => {
        if (link.href.includes(activePage)) {
            link.classList.add('active');
        }
        });
    </script>
    <script src="layout/js/bootstrap.min.js" ></script>

</body>
</html><!-- footer -->
<?php
}else{
    echo"You are to authzied to enter this page";
    header('location:../Users/index.php'); 

}














