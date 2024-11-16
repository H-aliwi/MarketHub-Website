<?php
session_start();
$NoNavbar = "";

include("intil.php"); //<!--  router -->
include("connection.php"); // Database connection file

// echo "ID :" . $_SESSION['UserID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['category'])) {
        // Loop through the checked categories
        foreach ($_POST['category'] as $category) {
            // Do something with each checked category
            echo $category . "<br>";
        }
    } else {
        echo "No categories selected.";
    }
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hashpass = sha1($pass);
    $mil = $_POST['mil'];
    $sname = $_POST['sname'];
    $logo = $_POST['logo'];
    $trade = $_POST['trade'];
    $sdsc = $_POST['sdsc'];
    $pay = $_POST['pay'];

    $itemImage = $_FILES['logo']['name'];
    $item_img_tmp = $_FILES['logo']['tmp_name'];


    // Create an SQL statement with to insert  shop_owner information
    $sql = "INSERT INTO shop_owner (Username, Password, Email,admin_feedback) VALUES (?, ?, ?,'Your account is under verification. We appreciate your patience. Full access will be granted as soon as the admin verification ends')";
    // Prepare the SQL statement
    $stmt = $con->prepare($sql);

    // Bind the parameters to the statement
    $stmt->execute(array($user, $hashpass, $mil));

    if ($stmt) {
        move_uploaded_file($item_img_tmp, "../shop_owner/layout/images/logo/$itemImage");


        echo 'Shop_owner details have been inserted successfully';
    // Create an SQL statement with to insert  shpo information
    $sql_2 = "INSERT INTO shop (Shop_OwnerID, shop_Name,shop_Logo, shop_Description, payment_Information, start_date) 
                    VALUES ((SELECT Shop_OwnerID FROM shop_owner WHERE Username = ? AND Password = ?), ?,?, ?, ?, NOW())";

        // Prepare the SQL statement
        $stmt_2 = $con->prepare($sql_2);
        // Bind the parameters to the statement
        $stmt_2->execute(array($user, $hashpass, $sname,$itemImage, $sdsc, $pay));

        if ($stmt_2) {
            echo "Shop details have been inserted successfully";

            // Insert shop category
            if (isset($_POST['category'])) {
                // Loop through the checked categories
                foreach ($_POST['category'] as $category) {
                    // Do something with each checked category
                    echo $category . "<br>";

                    // Create an SQL statement with to insert shop_category information
                    $sql_3 = "INSERT INTO shop_category (shopID, Category_ID)
                        VALUES ((SELECT s.shopID FROM shop_owner so, shop s WHERE so.Shop_OwnerID = s.Shop_OwnerID AND so.Username = ? AND so.Password = ?), ?)";

                    $stmt_3 = $con->prepare($sql_3);
                    // Bind the parameters to the statement
                    $stmt_3->execute(array($user, $hashpass, $category));

                    if ($stmt_3) {
                        echo "shop_category has been inserted successfully";
                    } else {
                        echo "Error inserting shop_category";
                    }
                }
            } else {
                echo "No categories selected.";
            }
        } else {
            echo 'Error inserting shop details.';
        }
        echo '<div class="alert alert-success">data successfully inserted</div>';

       
        exit();
        

    }  

    
    else {
        echo 'Error inserting shop_owner details.';
    }
}

include($tmpl . 'footer.php'); //<!-- footer -->
?>