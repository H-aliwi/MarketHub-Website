<style>


</style>

<?php
session_start();

// Include the necessary files and establish a database connection
include("connection.php");




if (isset($_POST['fromDate_p_cus']) && isset($_POST['toDate_p_cus']) ) {
    $fromDate_p_cus = $_POST['fromDate_p_cus'];
    $toDate_p_cus = $_POST['toDate_p_cus'];

    // Perform the database query to fetch the data based on the dates
    // You can modify the query according to your table structure and requirements

    // Example query:
    $query = "SELECT *
    FROM customer
    WHERE start_date >= ?
      AND start_date <= ?
    ORDER BY start_date DESC;";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array($fromDate_p_cus,$toDate_p_cus));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML table
    if ($stmt->rowCount() > 0) {
        echo '<div class="container mt-4 table-responsive bg-form-sec">';
        echo '<table id="customer_report" class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Customer ID</th>';
        echo '<th>username</th>';
        echo '<th>Customer State</th>';
        echo '<th>Email </th>';
        echo '<th>fullname</th>';
        echo '<th>address</th>';
        echo '<th>start Date</th>';
        echo '<th>age</th>';
        echo '<th>gender</th>';

        
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr style="
            background-color: white;
        ">';
            echo '<td>' . $row['CustomerID'] . '</td>';
            echo '<td>' . $row['Username'] . '</td>';
            echo '<td>' . $row['Customer_state'] . '</td>';
            echo '<td>' . $row['Email'] . '</td>';
            echo '<td>' . $row['fullname'] . '</td>';
            echo '<td>' . $row['address'] . '</td>';
            echo '<td>' . $row['start_date'] . '</td>';
            echo '<td>' . $row['age'] . '</td>';
            echo '<td>' . $row['gender'] . '</td>';


            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'No customers  found.';
    }
}
?>