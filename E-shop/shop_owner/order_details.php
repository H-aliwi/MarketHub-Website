<?php
session_start();
$pageTitle = "Order details";

include("intil.php");  //<!-- router -->


if (isset($_SESSION['shop_onwer_id']) && isset($_GET['orderID'])) {

      error_reporting(E_ERROR |E_PARSE);


      if (isset($_POST['submit'])) {
        include("connection.php");

        include('includes/functions/getShopID.php');

        $ownerId = $_SESSION['shop_onwer_id'];
        $shopID = getShopID($ownerId);
        $id = $_POST['orderID'];
      
        $stmnt = $con->prepare("UPDATE shop_order SET Delivered_date = NOW(), IsDelivered = 'Yes' WHERE Order_ID = :id ANd shopID =:shopid");
        $stmnt->bindParam(':id', $id);
        $stmnt->bindParam(':shopid', $shopID);


        
        $success = $stmnt->execute();
      
        if ($success) {
          echo '<script>alert("Order Delivered state has been updated successfully.");</script>';
          header("Location: order_details.php?orderID=$id");

        } else {
          echo '<script>alert("Update failed.");</script>';
        }
      }


    ?>
    

<style>
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #192a51;
    background-color: #Eaeaea;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.buttons_R a {
    background-color: #dc3545;
    color: white;
    padding: 6px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;

    border: 1px solid transparent;
    font-size: 16px;
    line-height: 1.5;
    border-radius: 0.25rem;
}
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
        .fa-arrow-left:before {
    content: "\f060";
    font-size: 28px;
    color: white;
}
</style>

<?php
        // include functions
        include('includes/functions/getShopID.php');
        include('includes/functions/getCategryName.php');
        include('includes/functions/getSubCategryName.php');

        $ownerId = $_SESSION['shop_onwer_id'];
        $shopID = getShopID($ownerId);

        include("connection.php");
        $stat = $con->prepare("SELECT i.Discount_Percent,ord.Order_ID, s.shopID, od.quantity  ,c.CustomerID, c.fullname, ord.Admin_note, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date, od.quantity ,c.Phone_number ,i.Title,i.Price,i.Item_image
        FROM shop s
        INNER JOIN item i ON s.shopID = i.shopID
        INNER JOIN order_detalis od ON i.ItemID = od.ItemID
        INNER JOIN orders ord ON ord.Order_ID = od.Order_ID
        INNER JOIN shop_order so ON s.shopID = so.shopID AND so.Order_ID = ord.Order_ID
        INNER JOIN customer c ON c.CustomerID = ord.CustomerID
        WHERE so.shopID =? and so.Order_ID= ?
        GROUP BY ord.Order_ID, s.shopID, c.CustomerID, c.fullname, ord.Admin_note, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date, od.quantity,c.Phone_number ,i.Title,i.Price,i.Item_image;");
        $stat->execute(array($shopID,$_GET['orderID']));
        $orderDetails = $stat->fetchAll();  // get all rows of data from DB
        $count = $stat->rowCount();  // count the number of rows

      
    ?>


<section class="dashboard">
 <?php
     if (count($orderDetails) > 0) {
        echo '<div class="order-container">';
      
        echo ' <h2 class="text-center p-2 m-0 "style="background-color: #192a51; color:white; 
        font-size:25px;"> <a href="orders.php" style="color:white"><span style="float: left;"><i class="fa-solid fa-arrow-left"></i></span></a> Order Id:#' . $_GET['orderID'] . '  Details</h2>
         ';
        echo '<div id="order_details">';
        foreach ($orderDetails as $detail) {
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

                        $total=+$discountedPrice * $detail['quantity'];
                        
                        echo '<p> Price : ' .$discountedPrice . '</p>';
                    } else {
                        $total=+$detail['Price'] * $detail['quantity'];

                        echo '<p> Price: ' .$detail['Price'] . '</p>';
                    }           echo'     </div>
            </div>';
        }

        echo' <div class="order-detail-item row"><h5 class="text-center">Total price: '.$total.' BD</h5></div>';
        echo '
            <div class="order-detail-item row" style="
                display: flex;
                justify-content: space-between;
                align-content: space-around;
            ">
            <p class="text-center order-first">Customer Name: <span style="font-weight: 300;color: #6c757d;">'.$detail['fullname'].' </span></p>
            <p class="text-center order-first">Order Date: <span style="font-weight: 300;color: #6c757d;">'.$detail['Order_date'].' </span></p>
                <br><p class="text-center order-first">Is Delivered: <span style="font-weight: 300;color: #6c757d;">'.$detail['IsDelivered'].' </span></p>
                <p class="text-center order-first mt-2">Customer address: <span style="font-weight: 300;color: #6c757d;">'.$detail['address'].' </span></p>
                <br><p class="text-center order-first mt-2 ">Customer Phone: <span style="font-weight: 300;color: #6c757d;">'.$detail['Phone_number'].' </span></p><br>';

            if ($detail['IsDelivered'] === 'No') {
                echo '<div class="mt-5 mb-3  mx-auto">
                <form method="post">
                    <input type="hidden" name="orderID" value="'.$_GET['orderID'].'">
                    <button type="submit" name="submit" class="btn">Confirm Delivery</button>
                </form></div>';
            }

            echo '
            </div>';
   


        
        echo '</div>'; // Close #order_details

        echo '</div>'; // Close .order-container
    } else {
        echo '<div class="no-order-details">No order details found for the given order ID.</div>';
    }

 ?>

</section>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {

    $('.updatebtn-item').on('click', function() {
        event.preventDefault(); // Prevent the default form submission

        $('#updatemodal').modal('show');


    });
});

// start getSubCaetogry

function getSubCaetogry() {
    var categoryId = document.getElementById("catogry-list").value; // Get the selected category ID

    // Make an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getSubCategories.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("sub-Category-list").innerHTML = xhr
                .responseText; // Update the sub-category options
        }
    };
    xhr.send("categoryId=" + categoryId); // Send the selected category ID to the PHP script
}

// END
</script>

<?php
    include($tmpl . 'footer.php'); //<!-- footer -->
} else {
    echo "You are not authorized to enter this page";
    header('location:../Users/index.php');
}
?>