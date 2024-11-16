<?php

// Include the necessary files and establish a database connection
include("connection.php");
include('includes/functions/getSubCategryName.php');

// Get the selected category ID from the AJAX request
$categoryId = $_POST['categoryId'];
echo"sds".$categoryId ;
// Prepare and execute the query to retrieve the sub-categories
$stat = $con->prepare("SELECT * FROM category_subcategories WHERE Category_ID= ?");
$stat->execute(array($categoryId));

// Generate the HTML options for the sub-categories
$options = '';
while ($row = $stat->fetch()) {
    $subCategryId=$row['Sub_Category_ID'];
    $SubCategryName=getSubCategryName($subCategryId); 
    $subCategoryId = $row['Sub_Category_ID'];

    $options .= '<option value="'. $subCategoryId .'">'. $SubCategryName .'</option>';
}


// Return the generated options as the response
echo $options;
?>