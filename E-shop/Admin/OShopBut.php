<?php 
session_start();

if (!isset($_SESSION['adminID'])) {
  header('location:../Users/index.php'); 
}
else{
    $AID = $_SESSION['adminID'];
    require("connection.php");
    
            if (isset($_POST['updateblock'])) {
            $id = $_POST['blockOShopId'];
            $BlkAdFeedback = $_POST['BlkAdFeedback'];
            
            //echo $id;
            //echo $BlkAdFeedback;
            $stmnt = $db->prepare("UPDATE shop_owner SET Shop_owner_state = 'Blocked', admin_feedback = '$BlkAdFeedback', adminID = $AID WHERE Shop_OwnerID = '$id' ");
            $stmnt->execute();
            }
        
            if (isset($_POST['updateVer'])) {
                $id = $_POST['verShopId'];
                $VrAdFeedback = $_POST['VrAdFeedback'];
                $stmnt = $db->prepare("UPDATE shop_owner SET Shop_owner_state = 'Verifying', admin_feedback = '$VrAdFeedback', adminID = $AID WHERE Shop_OwnerID = '$id' ");
                $stmnt->execute();
                //echo $id;
                //echo $VrAdFeedback;
            }
            header("Location: http://localhost/E-shop/Admin/users.php");
            exit; 
    

        }
?>