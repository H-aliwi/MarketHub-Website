<?php 
    session_start();
    require("connection.php");
    
            if (isset($_POST['updateblock'])) {
            $id = $_POST['blockItemId'];
            $BlkAdFeedback = $_POST['BlkAdFeedback'];
            
            //echo $id;
            //echo $BlkAdFeedback;
            $query = $db->prepare("UPDATE item SET Item_state = 'Blocked', Admin_feedback = '$BlkAdFeedback' WHERE ItemID = '$id' ");
            $query->execute();
            }
        
            if (isset($_POST['updateVer'])) {
                $id = $_POST['verItemId'];
                $VrAdFeedback = $_POST['VrAdFeedback'];
                $query = $db->prepare("UPDATE item SET Item_state = 'Verifying', Admin_feedback = '$VrAdFeedback' WHERE ItemID = '$id' ");
                $query->execute();
            }
            header("Location:items.php");
            exit; 
    

   
?>