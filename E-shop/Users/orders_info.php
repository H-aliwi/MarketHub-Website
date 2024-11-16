<?php
session_start();
if (isset($_SESSION['usernameA']) && isset($_GET['orderID'])) {
    $NoFooter ="";

    $pageTitle = "Order Information";
    include("intil.php"); //<!-- Router -->
    include("connection.php");
    $stat = $con->prepare("SELECT  od.ItemID, od.quantity, i.Item_image, i.Price, i.Title, i.Discount_Percent, o.Total_price 
    FROM order_detalis od 
    INNER JOIN item i ON od.ItemID = i.ItemID 
    INNER JOIN orders o ON od.Order_ID = o.Order_ID 
    WHERE od.Order_ID  = ?");
    $stat->execute(array($_GET['orderID']));
    $orderDetails = $stat->fetchAll();  // get all rows of data from DB
    $count = $stat->rowCount();  // count the number of rows
    ?>

    <style>
        .order-detail-item {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            max-width: 100%;
            margin: 0px;
        }

        .order-detail-item img {
            width: 50%;
            height: auto;
            margin-bottom: 10px;
        }

        .order-detail-item p {
            margin: 0;
        }

        .no-order-details {
            text-align: center;
            margin: 200px auto;
            color: #777;
        }

        .order-container {
            max-width: 760px;
            margin: 0 auto;
            padding: 20px;
        }

        .order-container h2 {
            margin-top: 0;
            padding-top: 0;
            width: 100%;
        }
    </style>
    <?php
    if (count($orderDetails) > 0) {
        echo '<div class="order-container">';
      
        echo ' <h2 class="text-center p-2 m-0 "style="background-color: #192a51; color:white; 
        font-size:25px;"> <a href="my_orders.php" style="color:white"><span style="float: left;"><i class="fa-solid fa-arrow-left"></i></span></a> Order Id:#' . $_GET['orderID'] . '  Details</h2>
         ';
        echo '<div id="order_details">';
        foreach ($orderDetails as $detail) {
            $total=$detail['Total_price'];
            echo '
            <div class="order-detail-item row">
                <div class="col-md-6">
                <img src=\'../shop_owner/layout/images/items/'. $detail['Item_image'] . '\' class=\'card-img-top\' alt=\'...\'>

                </div>
                <div class="col-md-6">
                    <p>Item name: ' . $detail['Title'] . '</p>
                    <p>Quantity: ' . $detail['quantity'] . '</p>';

                    if ($detail['Discount_Percent'] > 0) {
                        $discountPercent = $detail['Discount_Percent'];
                        $price = $detail['Price'];
                        $discountedPrice = $price - ($price * ($discountPercent / 100));
                        
                        echo '<p> Price : ' .$discountedPrice . ' BD</p>';
                    } else {
                        echo '<p> Price: ' .$detail['Price'] . ' BD</p>';
                    }
               echo' </div>
            </div>';
        }

        echo' <div class="order-detail-item row"><h5 class="text-center">Total price:'.$total.' BD </h5></div>';

        
        echo '</div>'; // Close #order_details

        echo '</div>'; // Close .order-container
    } else {
        echo '<div class="no-order-details">No order details found for the given order ID.</div>';
    }
?>

<?php include($tmpl . 'footer.php'); //<!-- footer -->


// Redirect to login
} else {
    echo "You are not authorized to enter this page";
    header('location:index.php');
}
?>