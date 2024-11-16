<?php  
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
$pageTitle = "Admin Home";

include("intil.php");  //<!-- router -->


include('includes/functions/GetItemsNO.php');
include('includes/functions/GetOrderNO.php');
include('includes/functions/GetShopNO.php');
include('includes/functions/GetNewShop.php');


$Total_web_items=GetItemsNO();
$Total_web_orders=GetOrderNO();
$Total_web_shops=GetShopNO();
$Total_web_New_shops=GetNewShop();


require("connection.php");
$query = "
            SELECT ord.Order_ID, c.CustomerID, c.fullname, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date, SUM(i.Price * od.quantity) AS Total_Price
            FROM shop s
            INNER JOIN item i ON s.shopID = i.shopID
            INNER JOIN order_detalis od ON i.ItemID = od.ItemID
            INNER JOIN orders ord ON ord.Order_ID = od.Order_ID
            INNER JOIN shop_order so ON s.shopID = so.shopID AND so.Order_ID = ord.Order_ID
            INNER JOIN customer c ON c.CustomerID = ord.CustomerID
            GROUP BY ord.Order_ID, c.CustomerID, c.fullname, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date
            ORDER BY ord.Order_date DESC
            LIMIT 5;";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array());

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// query 2
$query_2 = "
            SELECT i.ItemID, i.Title, s.shop_Name , i.Item_state ,i.List_date 
            FROM item i ,shop s 
            WHERE i.shopID =s.shopID 
            ORDER BY i.List_date DESC
            LIMIT 5;";

    // Prepare the statement
    $stmt_2 = $db->prepare($query_2);

    // Execute the query with the provided values
    $stmt_2->execute(array());

    // Fetch the results
    $results_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

// END query 2


?>


    <section class="dashboard">

        <!-- <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->
            
            <!--<img src="images/profile.jpg" alt="">-->

        <h2>Admin Dashboard</h2>


        </div>
        <div class="dash-content">
            <div class="overview">
                <!-- <div class="title">
                    <span class="text">Admin Dashboard</span>
                </div> -->
                <div class="boxes mr-3 ml-3">
                    <div class="box box1">
                        <span class="text">items</span>
                        <span class="number"><?php echo $Total_web_items;    ?></span>
                    </div>
                    <div class="box box2">
                        <span class="text">Orders</span>
                        <span class="number"><?php echo $Total_web_orders;   ?></span>
                    </div>
                    <div class="box box3">
                        <span class="text">Shops</span>
                        <span class="number"><?php echo $Total_web_shops;   ?></span>
                    </div>
                    <div class="box box4">
                        <span class="text">New shops requests</span>
                        <span class="number"><?php echo $Total_web_New_shops;   ?></span>
                    </div>
                </div>
            </div>
            <div class="container">

            <!-- start disaply item  -->
            <div class="row mt-4">
        <div class="col-12  mb-lg-5">
            <div class="overflow-hidden card table-nowrap table-card">
                <div class=" d-flex justify-content-between align-items-center">
                    <!-- <h5 class="mb-0">Items table</h5> -->
                    <!-- <a href="#!" class="btn btn-light btn-sm"><i class="fa-sharp fa-solid fa-plus"></i>Add New item</a> -->
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="small text-uppercase bg-body text-muted">
                        <tr><th colspan="14"><div class="card-header-o mt-1 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Items</h5>
                </div></th></tr>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Title</th>
                                <th>Shop Name</th>
                                <th>Item state</th>
                                <th>List Date</th>

                            </tr>
                        </thead>
                        <tbody>
                     <?php
                            if ($stmt_2->rowCount() > 0) {
                                foreach ($results_2 as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row['ItemID'] . '</td>';
                                    echo '<td>' . $row['Title'] . '</td>';
                                    echo '<td>' . $row['shop_Name'] . '</td>';
                                    echo '<td>' . $row['Item_state'] . '</td>';
                                    echo '<td>' . $row['List_date'] . '</td>';
                                    echo '</tr>';


                                }

                            }
                            else{
                                echo '<td><div style="text-align: center; margin:auto;">No Orders found.</div></td>';

                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- </div>  to enable container below--> 

            <!-- End disaply items -->


                        <!-- disply orders -->
    <div class="row mt-4">
        <div class="col-12  mb-lg-5">
            <div class="overflow-hidden card table-nowrap table-card">
                <div class=" d-flex justify-content-between align-items-center">
                    <!-- <h5 class="mb-0">Items table</h5> -->
                    <!-- <a href="#!" class="btn btn-light btn-sm"><i class="fa-sharp fa-solid fa-plus"></i>Add New item</a> -->
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="small text-uppercase bg-body text-muted">
                        <tr><th colspan="14"><div class="card-header-o mt-1 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent orders</h5>
                </div></th></tr>
                            <tr>
                                <th>Order_ID</th>
                                <th>Order_date</th>
                                <th>CustomerID</th>
                                <th>Customer name</th>
                                <th>Total_Price</th>
                                <th>address</th>
                                <th>IsDelivered</th>

                            </tr>
                        </thead>
                        <tbody>
                     <?php
                            if ($stmt->rowCount() > 0) {
                                foreach ($results as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row['Order_ID'] . '</td>';
                                    echo '<td>' . $row['Order_date'] . '</td>';
                                    echo '<td>' . $row['CustomerID'] . '</td>';
                                    echo '<td>' . $row['fullname'] . '</td>';
                                    echo '<td>' . $row['Total_Price'] . '</td>';
                                    echo '<td>' . $row['address'] . '</td>';
                                    echo '<td>' . $row['IsDelivered'] . '</td>';
                                    echo '</tr>';


                                }

                            }
                            else{
                                echo '<td><div style="text-align: center; margin:auto;">No Orders found.</div></td>';

                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- end dipaly orders -->
            


        </div>

        <!-- code here -->


    </section>

<?php 
}
include($tmpl . 'footer.php'); //<!-- footer -->
?>