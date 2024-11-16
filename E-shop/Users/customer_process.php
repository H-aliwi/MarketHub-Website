<?php
session_start();
$NoNavbar = "";

include("intil.php"); //<!--  router -->
include("connection.php"); // Database connection file

// echo "ID :" . $_SESSION['UserID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hashpass = sha1($pass);
    $mil = $_POST['mil'];
    $phone = $_POST['phone'];
    $fname = $_POST['fname'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];




    $itemImage = $_FILES['img']['name'];
    $item_img_tmp = $_FILES['img']['tmp_name'];


    // Create an SQL statement with to insert  shop_owner information
    $sql = "INSERT INTO customer (Username, Password, Email,age,gender,fullname,address,Account_img,Phone_number) VALUES (?, ?, ?,?,?,?,?,?,?)";
    // Prepare the SQL statement
    $stmt = $con->prepare($sql);
    move_uploaded_file($item_img_tmp, "layout/images/C_account/$itemImage");

    // Bind the parameters to the statement
    $stmt->execute(array($user, $hashpass, $mil,$age,$gender,$fname,$address,$itemImage,$phone));

    if ($stmt) {



       
        exit();
        

    }  
    else {
        echo 'Error inserting custoer details.';
    }
}

include($tmpl . 'footer.php'); //<!-- footer -->
?>