
<style>
    #effect-options {
    
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
      width: 260px;
    }
    #selected-content {
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
    button {
      margin-top: 10px;
    }
  </style>
<?php
session_start();
include('includes/functions/getshopOwnerUsernameByUserId.php'); 
include('includes/functions/CkeckSenderMsg.php');


// Establish database connection
include("connection.php");

// if (isset($_SESSION['Room_id'])){ $Room_id=$_SESSION['Room_id']; }

$receiverID = $_GET['receiverID'];
$roomID = $_GET['roomID'];

// echo "receiver :".$receiverID ." %%%% room: ".$roomID ;
// 
$receiver_id = $receiverID;

$stat = $con->prepare("SELECT * FROM messages WHERE chat_room_id = ?  ORDER BY Message_ID ASC ");

$stat->execute(array($roomID));
// Display messages
if ($stat->rowCount() > 0) {
    while ($row = $stat->fetch()) {
      $senderID=$row['sender_id'];
      $user=$_SESSION['usernameA'];
      $IS_customer=CkeckSenderMsg($senderID,$user);
          // echo "IS_customer: ".$IS_customer;

      if ($IS_customer==1)
      {
        $sender = $_SESSION['usernameA'];

      }
      else{ 
        $userId=$row['sender_id'];
        $shop_owner_Username= getshopOwnerUsernameByUserId($userId);

        $sender = $shop_owner_Username;}
      


        $message = $row['message_text'];
        $timestamp = strtotime($row['timestamp']);
        $formatted_timestamp = '';
 
        $now = new DateTime();
        $message_time = DateTime::createFromFormat('Y-m-d H:i:s', $row['timestamp']);
        $interval = $now->diff($message_time);
 
        if ($interval->days === 0) {
            $formatted_timestamp = 'Today ' . $message_time->format('h:i a');
        } elseif ($interval->days === 1) {
            $formatted_timestamp = 'Yesterday ' . $message_time->format('h:i a');
        } else {
            $formatted_timestamp = $message_time->format('M d, Y h:i a');
        }
        echo '<div class="content" data-content="' . $row['Message_ID'] . '">
                <div style="position: relative;">
                    <strong>'.$sender.'</strong>: '.$message. 
                    '<p style="font-size: 11px;">'.$formatted_timestamp.'</p>
                    <hr>
                </div>
               </div>
        
        ';
       
    }
?>


<?php

 
} else {
    echo
    '<div style="text-align: center;
    margin: 207px auto;">  No messages found. </div>';
}
?>

