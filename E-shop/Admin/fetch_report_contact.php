<style>


</style>

<?php
session_start();

// Include the necessary files and establish a database connection
include("connection.php");




if (isset($_POST['fromDate_p_con']) && isset($_POST['toDate_p_con']) ) {
    $fromDate_p_con = $_POST['fromDate_p_con'];
    $toDate_p_con = $_POST['toDate_p_con'];

    // Perform the database query to fetch the data based on the dates
    // You can modify the query according to your table structure and requirements

    // Example query:
    $query = "SELECT * FROM contact_form WHERE Send_date >= ? AND Send_date <= ? 
    ORDER BY Send_date DESC;";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Execute the query with the provided values
    $stmt->execute(array($fromDate_p_con,$toDate_p_con));

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML table
    if ($stmt->rowCount() > 0) {
        echo '<div class="container mt-4 table-responsive bg-form-sec">';
        echo '<table id="contact_report" class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Form ID</th>';
        echo '<th>Send Date</th>';
        echo '<th>Sender Name</th>';
        echo '<th>Sender Email </th>';
        echo '<th>title</th>';
        echo '<th>Description</th>';
        echo '<th>Reply Text</th>';
        echo '<th>Reply Date</th>';

        
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr style="
            background-color: white;
        ">';
            echo '<td>' . $row['Form_ID'] . '</td>';
            echo '<td>' . $row['Send_date'] . '</td>';
            echo '<td>' . $row['Sender_name'] . '</td>';
            echo '<td>' . $row['Sender_email'] . '</td>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['Reply_text'] . '</td>';
            echo '<td>' . $row['Reply_date'] . '</td>';


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