<style>
 
</style>

<?php
session_start();

// Include the necessary files and establish a database connection
include("connection.php");
include('includes/functions/getShopID.php');

$ownerId = $_SESSION['shop_onwer_id'];
$shopID = getShopID($ownerId);

if (isset($_POST['fromDate_p']) && isset($_POST['toDate_p'])) {
    $fromDate_p = $_POST['fromDate_p'];
    $toDate_p = $_POST['toDate_p'];

    //  query:
    $query = "SELECT *
              FROM  shop_payment sp ,shop s
              WHERE  s.shopID =sp.shopID AND 
                     sp.Paid_date >= ?  AND  sp.Paid_date <= ?
                                         AND  sp.shopID =?";

    // Prepare the statement
    $stmt = $con->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array($fromDate_p, $toDate_p,$shopID));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML table
    if ($stmt->rowCount() > 0) {
        echo '<div class="container mt-4 table-responsive bg-form-sec">';
        echo '<table id="orders_payment">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>payment_ID </th>';
        echo '<th>Shop ID</th>';
        echo '<th>paid admin ID</th>';
        echo '<th>Order ID</th>';
        echo '<th>Is Paid</th>';
        echo '<th>Paid date</th>';
        echo '<th>Paid price</th>';
 

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['payment_ID'] . '</td>';
            echo '<td>' . $row['shopID'] . '</td>';
            echo '<td>' . $row['paid_admin_ID'] . '</td>';
            echo '<td>' . $row['Order_ID'] . '</td>';
            echo '<td>' . $row['IsPaid'] . '</td>';
            echo '<td>' . $row['Paid_date'] . '</td>';
            echo '<td>' . $row['Paid_price'] . '</td>';
         

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'shop does not have payment in this range or no data found.';
    }
}
?>