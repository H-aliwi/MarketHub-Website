<?php
session_start();
include("connection.php");

if (isset($_POST['query'])) {
  $searchQuery = $_POST['query'];

  // Query to retrieve matching items based on the search query
  $itemQuery = $con->prepare("SELECT i.*, category.Category_name, sub_category.Sub_Category_name
  FROM item AS i
  INNER JOIN category ON i.Category_ID = category.Category_ID
  LEFT JOIN sub_category ON i.Sub_Category_ID = sub_category.Sub_Category_ID
  INNER JOIN category_subcategories cc ON cc.Category_ID = i.Category_ID AND cc.Sub_Category_ID = i.Sub_Category_ID
  INNER JOIN shop AS s ON i.shopID = s.shopID
  INNER JOIN shop_owner AS so ON s.Shop_OwnerID = so.Shop_OwnerID
  WHERE (i.Title LIKE :searchQuery
         OR category.Category_name LIKE :searchQuery
         OR category.keywords LIKE :searchQuery
         OR cc.keywords_ca LIKE :searchQuery
         OR sub_category.Sub_Category_name LIKE :searchQuery)
    AND i.Quantity > 0
    AND so.Shop_owner_state = 'Active'
    AND  i.Item_state ='Active';");
  $itemQuery->execute(['searchQuery' => "%$searchQuery%"]);


  // Fetch the matching items
  $matchingItems = $itemQuery->fetchAll(PDO::FETCH_ASSOC);
  unset($_SESSION['search_results']);

  // Store the search results in a session variable
  $_SESSION['search_results'] = $matchingItems;

  // Redirect to the search results page
  echo json_encode(['success' => true]);
  exit();
}
?>