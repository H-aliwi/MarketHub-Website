<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    include("connection.php");

    // Get data that comes from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $Pnumber = $_POST['Pnumber'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $Id = $_SESSION['UserID'];

    $item_img_name = $_FILES['img']['name'];              // accessing image name
    $item_img_tmp = $_FILES['img']['tmp_name'];            // accessing image tmp_name
    $item_img_err = $_FILES['img']['error'];                // accessing image error

    // SQL statement
    $stat = $con->prepare("UPDATE customer SET Username = ?, Email = ?, fullname = ?, 
    Phone_number = ?, address = ?, age = ?, Account_img = ?
    WHERE CustomerID = ?");
    $stat->execute(array($username, $email, $name, $Pnumber, $address, $age, $item_img_name, $Id));

    if ($stat->rowCount() > 0) {
        if ($item_img_err === UPLOAD_ERR_OK) {
            move_uploaded_file($item_img_tmp, "layout/images/items/$item_img_name");
        }

        // Display success message
        ?>
        <div class="container  mt-3 bg-white" style="width: 40%; min-height: 110px;">
            <div class="row  justify-content-center mb-4">
                <h2 class="R-h2">Data updated successfully</h2>
            </div>
        </div>
        <?php

        // Return a response indicating the update was successful
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // Return a response indicating the update failed
        $response = array('status' => 'error');
        echo json_encode($response);
    }
} else {
    echo "You cannot access this page directly";
}

?>