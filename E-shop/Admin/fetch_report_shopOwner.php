<style>


</style>

<?php
session_start();

// Include the necessary files and establish a database connection
include("connection.php");




if (isset($_POST['fromDate_p_shop']) && isset($_POST['toDate_p_shop']) ) {
    $fromDate_p_shop = $_POST['fromDate_p_shop'];
    $toDate_p_shop = $_POST['toDate_p_shop'];

    // Perform the database query to fetch the data based on the dates
    // You can modify the query according to your table structure and requirements

    // Example query:
    $query = "SELECT *
    FROM shop
    JOIN shop_owner ON shop.Shop_OwnerID = shop_owner.Shop_OwnerID
    WHERE start_date >= ? AND start_date <= ?
    ORDER BY start_date DESC;";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array($fromDate_p_shop,$toDate_p_shop));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML table
    if ($stmt->rowCount() > 0) {
        
	

        echo '<div class="container mt-4 table-responsive bg-form-sec">';
        echo '<table id="shopOwner_report" class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>shop ID</th>';
        echo '<th>shop Name</th>';
        echo '<th>start Date </th>';
        echo '<th>Email </th>';
        echo '<th>Shop Owner State</th>';
        echo '<th>Payment Information</th>';
        echo '<th>Shop Description</th>';
        echo '<th>Shop rate</th>';
        echo '<th>Admin feedback</th>';

        
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr style="
            background-color: white;
        ">';
            echo '<td>' . $row['shopID'] . '</td>';
            echo '<td>' . $row['shop_Name'] . '</td>';
            echo '<td>' . $row['start_date'] . '</td>';
            echo '<td>' . $row['Email'] . '</td>';
            echo '<td>' . $row['Shop_owner_state'] . '</td>';
            echo '<td>' . $row['payment_Information'] . '</td>';
            echo '<td>' . $row['shop_Description'] . '</td>';
            echo '<td>' . $row['rate'] . '</td>';
            echo '<td>' . $row['admin_feedback'] . '</td>';


            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'No shop owners found.';
    }
}
?>