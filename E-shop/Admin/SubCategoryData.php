<?php 
session_start();
require("connection.php");

    if(isset($_POST['delSubCat']))
    {
        $id = $_POST['del_ID'];
        //echo $id;

        $query = $db->prepare("DELETE FROM sub_category WHERE Sub_Category_ID = :id");
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