<?php 
    session_start();
    require("connection.php");
    include("intil.php"); 

    $OID = $_GET["orderID"];

$sql = $db->prepare("SELECT o.Order_ID, s.shop_Name, i.Title AS item_name, i.Item_image, i.Price AS item_price, od.quantity, c.fullname AS customer_name, c.address, c.Phone_number
                     FROM orders o
                     JOIN order_detalis od ON o.Order_ID = od.Order_ID
                     JOIN item i ON od.ItemID = i.ItemID
                     JOIN shop s ON i.shopID = s.shopID
                     JOIN customer c ON o.CustomerID = c.CustomerID
                     WHERE o.Order_ID = $OID;");

$sql -> execute();
$rows = $sql->fetchAll();

$totalPrice = 0;

?>


<section class="dashboard">

    <h1>Order Details</h1>
    <hr class="mb-5">

    <table class="table bg-white">
        <thead><tr>
            <th colspan="6">Order ID :<?php echo $OID;  ?></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Item Photo</th>
                <th>Item Name</th>
                <th>Shop Name</th>
                <th>Quantity</th>
                <!-- <th>Customer Name</th> -->
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $info){ ?>
            <tr>
                <td><img src="../shop_owner/layout/images/items/<?php echo $info['Item_image']; ?>" alt="Description of the image" style="width: 55px;"></td>
                <td><?php echo $info['item_name']; ?></td>
                <td><?php echo $info['shop_Name']; ?></td>
                <td><?php echo $info['quantity']; ?></td>
                <td><?php echo $info['item_price']; ?>BD</td>
                </tr>
            <?php 
                $subtotal = $info['item_price'] * $info['quantity'];
                $totalPrice += $subtotal;
            ?>
            <?php } ?>
            
            <tr>
                <td colspan="4"><b>Total</b></td>
                <td><b><?php echo number_format($totalPrice, 3); ?>BD</b></td>
            </tr>

            <tr class="table-active">
                <td colspan="2"><b> Customer Name : <?php echo $info['customer_name']; ?></b><br>
                <b> Phone Number : <?php echo $info['Phone_number']; ?></b><br>
                <b> Address : <?php echo $info['address']; ?></b></td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>

</section>

<?php
        include($tmpl . 'footer.php'); //<!-- footer -->
?>