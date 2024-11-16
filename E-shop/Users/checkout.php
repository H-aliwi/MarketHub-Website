

<?php
session_start();
if(isset($_SESSION['usernameA'])){

	include('includes/functions/getCustomerinfo.php'); 

 
    $pageTitle = "checkout";
	$NoFooter ="";



	$CID=$_SESSION['UserID'];
	$CData=getCustomerinfo($CID);


        $Cemail = $CData['email'];
		$Cphone = $CData['phone_Number'];
        $Caddress = $CData['address'];
		$Cfullname = $CData['fullname'];


		// echo  $Cemail ." ". $Cphone ." ".$Caddress;

		if (isset($_POST['submit'])) {
			// Step 1: Insert into `orders`
			if (isset($_POST['total'])) {
				$total = $_POST['total'];
	
				include("connection.php");
	
				$stmt = $con->prepare("INSERT INTO orders (CustomerID , Order_date, Total_price) VALUES (:CustomerID , NOW(), :total)");
				$stmt->bindParam(':CustomerID', $_SESSION['UserID']);
				$stmt->bindParam(':total', $total);
				$stmt->execute();
	
				$orderID = $con->lastInsertId();
	
				// Step 2: Insert into `order_detalis`
				if (isset($_COOKIE['shopping_cart'])) {
					$cart_data = json_decode($_COOKIE['shopping_cart'], true);
	
					foreach ($cart_data as $key => $value) {
						$itemID = $value['item_id'];
						$quantity = $value['quantity'];
	
						$stmt = $con->prepare("INSERT INTO order_detalis (Order_ID, ItemID, quantity) VALUES (:Order_ID, :ItemID, :quantity)");
						$stmt->bindParam(':Order_ID', $orderID);
						$stmt->bindParam(':ItemID', $itemID);
						$stmt->bindParam(':quantity', $quantity);
						$stmt->execute();

						// 
						$stmt = $con->prepare("UPDATE item SET Quantity = Quantity - :quantity WHERE ItemID = :itemID AND Quantity >= :quantity");
						$stmt->bindParam(':quantity', $quantity);
						$stmt->bindParam(':itemID', $itemID);
						$stmt->execute();
	
						// Check if item quantity is 0
						if ($stmt->rowCount() > 0) {
							$stmt = $con->prepare("UPDATE item SET Item_state = 'sold' WHERE ItemID = :itemID AND Quantity = 0");
							$stmt->bindParam(':itemID', $itemID);
							$stmt->execute();
						}

						// 
					}


				}
	
				if (isset($_COOKIE['shopping_cart'])) {
					$cart_data = json_decode($_COOKIE['shopping_cart'], true);
					$uniqueShopIDs = array();
	
					foreach ($cart_data as $key => $value) {
						$shopID = $value['shopID'];
					// Step 3: Insert into `shop_oeders`

						if (!in_array($shopID, $uniqueShopIDs)) {
							$stmt = $con->prepare("INSERT INTO shop_order (shopID, Order_ID) VALUES (:shopID, :Order_ID)");
							$stmt->bindParam(':shopID', $shopID);
							$stmt->bindParam(':Order_ID', $orderID);
							$stmt->execute();
	
							$uniqueShopIDs[] = $shopID;
						}
					}
				}
	
				if (isset($_COOKIE['shopping_cart'])) {
					$cart_data = json_decode($_COOKIE['shopping_cart'], true);
					$uniqueShopIDs = array();
	
					foreach ($cart_data as $key => $value) {
						$shopID = $value['shopID'];
	
						if (!in_array($shopID, $uniqueShopIDs)) {
							$totalPaidPrice = 0;
	
							foreach ($cart_data as $cartItem) {
								if ($cartItem['shopID'] === $shopID) {
									$itemID = $cartItem['item_id'];
									$quantity = $cartItem['quantity'];
									$item_price = $cartItem['item_price'];
	
									$subtotal = $item_price * $quantity;
									$totalPaidPrice += $subtotal;
								}
							}
						// Step 4: Insert into `shop_payment`

							$stmt = $con->prepare("INSERT INTO shop_payment (shopID, Order_ID, Paid_price) VALUES (:shopID, :Order_ID, :Paid_price)");
							$stmt->bindParam(':shopID', $shopID);
							$stmt->bindParam(':Order_ID', $orderID);
							$stmt->bindValue(':Paid_price', $totalPaidPrice);
							$stmt->execute();
	
							$uniqueShopIDs[] = $shopID;
						}
					}
				}
			}            
			  setcookie("shopping_cart", "", time() - 3600);

			header('Location: ../gatee/process.php?total=' . $_POST['total'] .'&email=' . urlencode($_POST['email']) . '&name=' . urlencode($_POST['name']) . '&address=' . urlencode($_POST['address']) . '&mobile=' . urlencode($_POST['mobile']));	
					
			exit();
		}

		include("intil.php") ;  //<!--  rounter -->
	
                 
    include("connection.php");
?>

<style>

a{
	font: caption;
	font-size: 15px;
 }
 table
{
	font-family: Tahoma;
	font-size: 9pt;
	background-color: #eee;

}

th{
	font-weight: bold;
	text-align: center;
	height: 30px;
	border: 1px solid #C0C0C0;
	color: #FFFFFF;
	background-color: #3B9FD7;
    font-size: 16px;

}

tr
{
	color: #666666;
	background-color: #F3F3F3;
	border-left-width: 1px;
	border-right-width: 1px;
	border-top-width: 1px;
	border-bottom: 1px solid #FFFFFF;
}

p
{
	margin-left: 10px;
	margin-right: 10px;
    font-size: 14px;
}

input[type=text], textarea
{
	width: 95%;
	font-family: Tahoma;
	font-size: 10pt;
	padding: 3px;
	margin: 1px;
	border: 1px solid #999999;
}

input[type=text]
{
	height: 25px;
}
  
    
</style>
<div class="container">

<form method="POST" action="">

<input type="hidden" name="total" value="<?php echo $_POST['total']; ?>">
<div class="d-flex justify-content-center mt-5"> 
<table  width="509" cellspacing="0" cellpadding="0" height="441">
	<tr> 
		<th colspan="2">
		Gate-e API</th>
	</tr>
	<tr>
		<td class="cell1">
			<p>Customer Name</p>
		</td>
		<td class="cell2">
			<input type="text" name="name" value="<?php echo  $Cfullname  ?>" required>
		</td>
	</tr>
	<tr>
		<td class="cell1">
			<p>Customer Email</p>
		</td>
		<td class="cell2">
			<input type="text" name="email" value="<?php echo  $Cemail  ?>" required >
		</td>
	</tr>
	<tr>
		<td class="cell1">
			<p>Customer Mobile</p>
		</td>
		<td class="cell2">
			<input type="text" name="mobile" value="<?php echo  $Cphone  ?>" required placeholder="97335542122">
		</td>
	<tr>
		<td class="cell1">
			<p >Customer Address</p>
		</td>
		<td class="cell2">
			<textarea rows="2" name="address" cols="32"   required placeholder="Home 09, Bulding 11,Street 123, Manama." ><?php echo $Caddress;?></textarea> 
		</td>
	</tr>
	
	<tr>
		<td class="cell1" height="54">&nbsp;</td>
		<td class="cell2" height="54">
			<input type="submit" value="continue to pay" name="submit" style="
    padding: 2px 15px;
    font-size: 15px;
">
		</td>
	</tr>
</table>
</div>
</form>

   <?php include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>




