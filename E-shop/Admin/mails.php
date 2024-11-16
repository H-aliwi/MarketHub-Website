<?php
session_start();
require("connection.php");

$tmpl  = 'includes/templetes/';  // templetes deroctary
$func  = 'includes/functions/';  // functions deroctary

?>
<?php   include($func .'functionTitle.php')  ?><!--  function-->
<?php   include('includes/langauges/Eng.php')  ?><!--  eng -->
<?php   include($tmpl .'header.php')  ?><!--  header-->

<?php

if (!isset($NoNavbar)){

    include($tmpl .'navbar.php');

}

echo " <section class='dashboard'>";

echo "<h1> mails </h1>";

// Pagination settings
$perPage = 20; // Number of emails per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Calculate the offset for pagination
$offset = ($page - 1) * $perPage;

// Retrieve emails from the database
$sql = "SELECT * FROM contactform LIMIT $perPage OFFSET $offset";
$stmt = $db->prepare($sql);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="container" style="display: flex; justify-content: center;">
 <table>
    <thead><!--table header --->
      <tr> <!--table row 1 --->
        <th>Name</th>
        <th>Email</th>
        <th>Title</th>
        <th>Description</th>
        <th>Options</th>
    </tr>   
    </thead>


<?php
// Display the emails
foreach ($emails as $email) {
    $subject = $email['CTitle'];
    $message = $email['CDescription'];

    
    echo "<tbody>";
    echo " <tr><!--table row--->";
    echo "  <td>". $email['CName'] ."</td> <!--cell 1--->";
    echo "  <td>". $email['CEmail'] ."</td>   <!--cell 2--->";
    echo "  <td>". $subject ."</td>  <!--cell 3--->";
    echo "  <td>". $message ."</td>  <!--cell 4--->";
    echo "  <td>
            <a href='#'>Replay</a>
            <a href='#'>Delete</a>
            <a href='#'>Done</a>
         </td>  <!--cell 5--->";
    echo " </tr>";
    echo "</tbody>";
}
    
    echo "</table>";
    echo "</div>";

// Pagination links
$sql = "SELECT COUNT(*) AS total FROM contactform";
$totalStmt = $db->query($sql);
$totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
$totalEmails = $totalResult['total'];
$totalPages = ceil($totalEmails / $perPage);

// Display pagination links
echo '<div style="text-align: center;">';
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='yourpage.php?page=$i'>$i</a> ";
}
echo '</div>'; 
echo "</section>";

?>
