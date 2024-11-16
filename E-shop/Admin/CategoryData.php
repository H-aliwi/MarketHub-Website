<?php 
session_start();
require("connection.php");

    if(isset($_POST['delCat']))
    {
        $id = $_POST['del_id'];
        //echo $id;

        $query = $db->prepare("DELETE FROM category WHERE Category_ID = :id");
        $query->bindParam(':id', $id);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo '<script> alert("The category has been deleted"); </script>';
        } 
        else {
            echo '<script> alert("The category has not been deleted"); </script>';
        }

        header("Location: categories.php");
    }

?>