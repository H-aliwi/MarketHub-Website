
<?php
session_start();

// Include the necessary files and establish a database connection
include("connection.php");
include('includes/functions/getShopID.php');

$ownerId = $_SESSION['shop_onwer_id'];
$shopID = getShopID($ownerId);

if (isset($_POST['fromDate']) && isset($_POST['toDate'])) {
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];


    //  query:
    $query = "SELECT ord.Order_ID, s.shopID, c.CustomerID, c.fullname,
     c.address, so.IsDelivered, so.Delivered_date, ord.Order_date, 
     SUM(i.Price * od.quantity) AS Total_Price
    FROM shop s
    INNER JOIN item i ON s.shopID = i.shopID
    INNER JOIN order_detalis od ON i.ItemID = od.ItemID
    INNER JOIN orders ord ON ord.Order_ID = od.Order_ID
    INNER JOIN shop_order so ON s.shopID = so.shopID AND so.Order_ID = ord.Order_ID
    INNER JOIN customer c ON c.CustomerID = ord.CustomerID
    WHERE s.shopID = ? and ord.Order_date >= ? AND ord.Order_date <=?
    GROUP BY ord.Order_ID, s.shopID, c.CustomerID, c.fullname, c.address, so.IsDelivered, so.Delivered_date, ord.Order_date;";

    // Prepare the statement
    $stmt = $con->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array( $shopID,$fromDate, $toDate));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML table
    if ($stmt->rowCount() > 0) {
        echo '<div class="container mt-4 table-responsive table-card bg-form-sec">';
        echo '<table id="orders">';
        echo '<thead>';
        echo '<tr >';
        echo '<th>Order ID</th>';
        echo '<th>Shop ID</th>';
        echo '<th>Customer ID</th>';
        echo '<th>Customer Name</th>';
        echo '<th>Address</th>';
        echo '<th>Order_date</th>';
        echo '<th>Total_Price</th>';
        echo '<th>Is Delivered</th>';
        echo '<th>Delivered_date</th>';

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['Order_ID'] . '</td>';
            echo '<td>' . $row['shopID'] . '</td>';
            echo '<td>' . $row['CustomerID'] . '</td>';
            echo '<td>' . $row['fullname'] . '</td>';
            echo '<td>' . $row['address'] . '</td>';
            echo '<td>' . $row['Order_date'] . '</td>';
            echo '<td>' . $row['Total_Price'] . '</td>';
            echo '<td>' . $row['IsDelivered'] . '</td>';
            echo '<td>' . $row['Delivered_date'] . '</td>';

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'No data found.';
    }
}
?>