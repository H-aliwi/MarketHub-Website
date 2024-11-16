<?php 

session_start();
error_reporting(E_ERROR | E_PARSE);
$pageTitle = "Chat rooms";


if (isset($_SESSION['shop_onwer_id']) ) 
{
include("intil.php");  //<!-- router -->
include("connection.php");

include('includes/functions/getLastMessageByRoomId.php');
include('includes/functions/getCustomerIMGByUserId.php');


$stat = $con->prepare("select * from chat_room where user2_id=? ");
$stat->execute(array($_SESSION['shop_onwer_id']));
$rows = $stat->fetchAll();  // get all rows of data from DB
$count = $stat->rowCount();  // count the number of rows

?>

<section class="dashboard">
    <div class="container">
    </div>

    <div class="container-rooms">


        <h2 class="text-center p-2 m-0  " style="background-color: #192a51; color:white; font-size:25px;">Available
            Rooms</h2>
        <div id="rooms">
            <?php
        if ($count > 0) {
            foreach ($rows as $row) {
                // to get Customer_name who is the receiver also
                $Customer_name= getCustomerUsernameByUserId($row['user1_id']);
                $Customer_img= getCustomerIMGByUserId($row['user1_id']);

                
                // Get the last message for the chat room
                 $last_message = getLastMessageByRoomId($row['chat_room_id']);
                 
                // Format the timestamp
                $formatted_timestamp = '';

                $message_time = DateTime::createFromFormat('Y-m-d H:i:s', $last_message['timestamp']);
                if ($message_time instanceof DateTime) {
                    $now = new DateTime();
                    $interval = $now->diff($message_time);
            
                    if ($interval->days === 0) {
                        $formatted_timestamp = 'Today ' . $message_time->format('h:i a');
                    } elseif ($interval->days === 1) {
                        $formatted_timestamp = 'Yesterday ' . $message_time->format('h:i a');
                    } else {
                        $formatted_timestamp = $message_time->format('M d, Y h:i a');
                    }
                } else {
                    // Handle the case where the timestamp is invalid
                    $formatted_timestamp = 'none';
                }
            

                echo '<div style=" position: relative; padding:10px"> 
                <div class="row">
                <div class="col-sm-6">
                <a href="chat.php?receiver_ID='. $row['user1_id'].'&room_id='. $row['chat_room_id'].'">
                <img src="../Users/layout/images/C_account/'.$Customer_img.'" alt="Avatar">
                <strong>Chat with ' .$Customer_name . '</strong>
                </a>
                </div>
                 <div class="col-sm-6">
                  <div style=" position: absolute; top: 19px;  right: 6px;">
                <h5 style="font-size:13px"> start date: ' . $row['start_date'] . '</h5></div>
                <a href="delete_room.php?roomid='. $row['chat_room_id'].'">
                    <div style=" position: absolute; top: -10px;  right: 8px;">
                    <span><i class="fa-solid fa-xmark"></i></span>
                </a>
                 </div>
                </div>
               
                
               
                </div>
                <div style=" font-size: 12px;color: gray;"> last message: <span style="
                font-weight: 900;">' . $last_message['message_text'] . '</span>     <br>' . $formatted_timestamp. '</div>
                <hr>
                </div>';
            }
        } else {
            echo '<div style="text-align: center; margin: 207px auto;">No rooms found.</div>';
        }
        ?>
        </div>
    </div>
</section>

<?php
include($tmpl . 'footer.php'); //<!-- footer -->
}

    //Redirect to login
else{echo"You are to authzied to enter this page";
    header('location:../Users/index.php'); 
    }
?>