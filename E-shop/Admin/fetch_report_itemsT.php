<style>


</style>

<?php
session_start();

// Include the necessary files and establish a database connection
include("connection.php");




if (isset($_POST['fromDate_items']) && isset($_POST['toDate_items'])&& isset($_POST['shopID_itemsG']) ) {
    $fromDate_items = $_POST['fromDate_items'];
    $toDate_items = $_POST['toDate_items'];
    $shopID_itemsG =$_POST['shopID_itemsG'];
    // Perform the database query to fetch the data based on the dates
    // You can modify the query according to your table structure and requirements

    // Example query:
    $query = "SELECT i.ItemID, i.List_date, i.Item_state, i.Price, o.Order_ID, o.Order_date AS sold_date
    FROM item i
    JOIN order_detalis od ON i.ItemID = od.ItemID
    JOIN orders o ON od.Order_ID = o.Order_ID
    WHERE i.Item_state = 'sold'
      AND o.Order_date >= ?
      AND o.Order_date <= ?
      AND i.shopID = ?
    ORDER BY o.Order_date DESC;";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array( $fromDate_items, $toDate_items,$shopID_itemsG));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML table
    if ($stmt->rowCount() > 0) {
        echo '<div class="container mt-4 table-responsive bg-form-sec">';
        echo '<table id="items_sold" class="table"> ';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Item ID</th>';
        echo '<th>List date</th>';
        echo '<th>Item state</th>';
        echo '<th>Price</th>';
        echo '<th>Sold date</th>';
    

        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr style="
            background-color: white;
        ">';
            echo '<td>' . $row['ItemID'] . '</td>';
            echo '<td>' . $row['List_date'] . '</td>';
            echo '<td>' . $row['Item_state'] . '</td>';
            echo '<td>' . $row['Price'] . '</td>';
            echo '<td>' . $row['sold_date'] . '</td>';

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'No sold item found.';
    }
}
?>