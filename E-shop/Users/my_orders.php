
<?php
session_start();
if(isset($_SESSION['usernameA'])){
    $pageTitle = "My orders";
    include("intil.php") ;  //<!--  rounter -->
    include("connection.php");
    $stat = $con->prepare("SELECT o.*
    FROM orders o 
    INNER JOIN shop_order so ON o.Order_ID = so.Order_ID 
    WHERE o.CustomerID =?
    GROUP BY o.Order_ID
    ORDER BY o.Order_date DESC ");
    $stat->execute(array($_SESSION['UserID']));
    $rows = $stat->fetchAll();  // get all rows of data from DB
    $count = $stat->rowCount();  // count the number of rows
?>

<style>
    .container-orders {
        max-width: 760px;
        margin: 0 auto;
        padding: 20px;
        
    }

    #orders_li {
        height: 460px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #f5f5f5;
        border-radius: 5px;
        border: 1px solid #ccc;


    }

    #orders_li p {
        margin: 0;
    }

    #orders_li a {
        text-decoration: none;
        color: #192a51;
    }

    #orders_li a:hover {
        text-decoration: underline;
    }

    .order-item {
        position: relative;
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-date {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 14px;
        color: #777;
    }

    .no-orders {
        text-align: center;
        margin: 200px auto;
        color: #777;
        
    }
    a:link {
  text-decoration: none;
}
</style>
<div class="container-orders">
    <h2 class="text-center p-2 m-0" style="background-color: #192a51; color:white; font-size:25px;">My orders</h2>
    <div id="orders_li">
        <?php
        if ($count > 0) {
            foreach ($rows as $row) {
                echo '
                <div class="order-item">
                    <div class="row">
                        <div class="col-sm-6">
                       <a href="orders_info.php?&orderID='. urlencode($row['Order_ID']) . '">
                                <p>Order_ID: ' . $row['Order_ID'] . '</p>
                            </a>
                            <p>Total_price: ' . $row['Total_price'] . ' BD</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="order-date">
                                <h5 style="
                                font-size: 18px;
                                ">Order date: ' . $row['Order_date'] . '</h5>

                            </div>
                        </div>
                        
                    </div>
                </div>';
            }
        } else {
            echo '<div class="no-orders">No orders found.</div>';
        }
        ?>
    </div>
</div>




   <?php include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>




