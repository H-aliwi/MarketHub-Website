<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("connection.php"); // Database connection file
    include('includes/functions/getShopID.php');

    $ownerId = $_SESSION['shop_onwer_id'];
    $shopID = getShopID($ownerId);

    $selectedCategories = $_POST['Category'];
    $categoryID = implode(', ', $selectedCategories);

    $selectedSubCategories = $_POST['sub-Category'];
    if (empty($selectedSubCategories)) {
        $subcategoryID = NULL;
    } else {
        $subcategoryID = implode(', ', $selectedSubCategories);
    }

    $title = $_POST['title'];
    $itemDescription = $_POST['sdsc'];
    $price = $_POST['Price'];
    $quantity = $_POST['quntitiy'];
    $discountPercent = $_POST['Discount'];

    $itemImage = $_FILES['img']['name'];
    $item_img_tmp = $_FILES['img']['tmp_name'];


    // Prepare the INSERT statement
    $sql = $con->prepare("INSERT INTO `item` (`Category_ID`, `Sub_Category_ID`, `shopID`, `Title`, `Item_image`, `Item_description`, `Item_state`, `Price`, `Quantity`, `Discount_Percent`, `List_date`)
                           VALUES (?, ?, ?, ?, ?, ?, 'Active', ?, ?, ?, NOW())");

    $sql->execute(array($categoryID,$subcategoryID,$shopID,$title,$itemImage,$itemDescription,$price,$quantity,$discountPercent));

    if ($sql) {
            // Move the uploaded file to a desired directory

        move_uploaded_file($item_img_tmp, "layout/images/items/$itemImage");

    } else {
        echo "<script>alert('error')</script>";

    }

    // Redirect to the desired page with a success message
    // $message = "Data successfully inserted";
    // header("Location: items.php?message=" . urlencode($message));
    exit();
}
?>