<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
    $AID = $_SESSION['adminID'];
    require("connection.php");

            if (isset($_POST['updateVer'])) {
                $id = $_POST['verCusId'];
                $VrAdFeedback = $_POST['VrAdFeedback'];
                $stmnt = $db->prepare("UPDATE customer SET Customer_state = 'Verifying', admin_feedback = '$VrAdFeedback', adminID = $AID WHERE CustomerID  = '$id' ");
                $stmnt->execute();
                //echo $id;
                //echo $VrAdFeedback;
            }
    
            if (isset($_POST['updateblock'])) {
            $id = $_POST['blockCusId'];
            $BlkAdFeedback = $_POST['BlkAdFeedback'];
            //echo $id;
            //echo $BlkAdFeedback;
            $stmnt = $db->prepare("UPDATE customer SET Customer_state = 'Blocked', admin_feedback = '$BlkAdFeedback', adminID = $AID WHERE CustomerID = '$id' ");
            $stmnt->execute();
            }
        
            
            header("Location: http://localhost/E-shop/Admin/users.php");
            exit; 
    

        }
?>