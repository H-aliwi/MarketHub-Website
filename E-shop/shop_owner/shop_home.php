<?php 
session_start();
$pageTitle = "Shop owner home";

if (isset($_SESSION['shop_onwer_id']) ) 
{
    $user =$_SESSION['username_shop_owner'];
    // $pass = $_POST['pass'];
include("intil.php");  //<!-- router -->
include("connection.php");



$stat_2 = $con->prepare("select * from shop where Shop_OwnerID =? ");
$stat_2->execute(array($_SESSION['shop_onwer_id']));
$rows = $stat_2->fetch();  // get all rows of data from DB
$count_2 = $stat_2->rowCount();  // count the number of rows
if($count_2 >0){
    $shop_Name=$rows['shop_Name'];
    $shop_Logo=$rows['shop_Logo'];

}

include('includes/functions/getShopID.php');
include('includes/functions/get_shop_itemsNO.php');
include('includes/functions/get_shop_newOrdersNO.php');
include('includes/functions/get_shop_delivered_orders.php');
include('includes/functions/get_shop_rate.php');



$ownerId=$_SESSION['shop_onwer_id'];

// Get the shopID using the shpp_ownerId
$shopID = getShopID($ownerId);

// Get the count of items for the shop
$items_count = get_shop_itemsNO($shopID);

// Get the count of new orders for the shop
$new_orders_count = get_shop_newOrdersNO($shopID);

// Get the count of delivered orders for the shop
$orders_delivered_count = get_shop_delivered_orders($shopID);

// Get the rating for the shop
$shop_rate = get_shop_rate($shopID);




$query = "
        SELECT ord.Order_ID, s.shopID, c.CustomerID, c.fullname, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date, SUM(i.Price * od.quantity) AS Total_Price
        FROM shop s
        INNER JOIN item i ON s.shopID = i.shopID
        INNER JOIN order_detalis od ON i.ItemID = od.ItemID
        INNER JOIN orders ord ON ord.Order_ID = od.Order_ID
        INNER JOIN shop_order so ON s.shopID = so.shopID AND so.Order_ID = ord.Order_ID
        INNER JOIN customer c ON c.CustomerID = ord.CustomerID
        WHERE s.shopID =?
        GROUP BY ord.Order_ID, s.shopID, c.CustomerID, c.fullname, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date
        ORDER BY ord.Order_date DESC
        LIMIT 7;";

    // Prepare the statement
    $stmt = $con->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array($shopID));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
    .card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    margin-top:20px;
}
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
.card-header-o {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
}
</style>


    <section class="dashboard" style="
    min-height: 650px;
">
        <?php
        // echo "count=".$items_count;
        // echo "new ordrs=".$new_orders_count;
        // echo "delivered ordrs=".$orders_delivered_count;

        ?>


        <!-- <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title"
                            style="
                                    display: flex;
                                    flex-direction: row;
                                    justify-content: space-between;
                                    font-size: 20px;
                                    margin-right: 20px;
                                ">
                    <span class="text">Shop Owner Dashboard</span>
                    <span>             

                    <img src="layout/images/logo/<?php echo $shop_Logo?>" alt="Description of the image" class="rounded-circle" style="width: 35px;height: 35px;border: 1px solid black;">

                      <?php echo $shop_Name?>

                    </span>

                </div>
                <div class="boxes">
                    <div class="box box1">
                        <span class="text">Shop items</span>
                        <span class="number"><?php echo $items_count ?></span>
                    </div>
                    <div class="box box2">
                        
                        <span class="text">New Orders</span>
                        <span class="number"><?php echo $new_orders_count ?></span>
                    </div>
                    <div class="box box3">
                        <span class="text">delived Orders</span>
                        <span class="number"><?php echo $orders_delivered_count?></span>
                    </div>
                    <div class="box box4">
                        <span class="text">Shop rate</span>
                        <span class="number"><?php echo $shop_rate?></span>
                    </div>
                </div>
            </div>
                
<div class="container">
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
                
            </div>
            
        </div>

        <!-- code here -->


    </section>


<?php
include($tmpl . 'footer.php'); //<!-- footer -->

?>




   <?php

}

//Redirect to login
else{echo"You are to authzied to enter this page";
    header('location:../Users/index.php'); 
    }
?>

