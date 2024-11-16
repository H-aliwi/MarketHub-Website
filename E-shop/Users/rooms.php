
<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

if(isset($_SESSION['usernameA'])){
    $pageTitle = "Rooms";
    include("intil.php") ;  //<!--  rounter -->
    include("connection.php");
    $stat = $con->prepare("select * from chat_room where user1_id=? ");
    $stat->execute(array($_SESSION['UserID']));
    $rows = $stat->fetchAll();  // get all rows of data from DB
    $count = $stat->rowCount();  // count the number of rows

    
    include('includes/functions/getshopOwnerlogoByUserId.php');
    include('includes/functions/getLastMessageByRoomId.php');

    

?>

<style>
     .container-rooms{
    max-width: 760px;
    margin: 0 auto;
    padding: 20px;

}
.container-rooms img {
  float: left;
  max-width: 35px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

#rooms {
    height: 460px;
    overflow-y: scroll;
    border: 1px solid #ccc;
    padding: 10px;
background-color: white;
}

#rooms strong {
    color: #222222;

}
</style>
<?php
if (isset($_SESSION['show_message_newForm'])) {
    echo "<script>alert('Room has been deleted successfully.');</script>";
    unset($_SESSION['show_message_newForm']); // Reset the session variable
 }?>
<div class="container-rooms">
        

        <h2 class="text-center p-2 m-0  "style="background-color: #192a51; color:white; font-size:25px;">Available Rooms</h2>
        <div id="rooms" >
        <?php
        if ($count > 0) {
            foreach ($rows as $row) {
                // to get shop name and logo of the receiver
                $shop_name = getshopOwnerUsernameByUserId($row['user2_id']);
                $shop_logo = getshopOwnerlogoByUserId($row['user2_id']);
                // Get the last message for the chat room
                $last_message = getLastMessageByRoomId($row['chat_room_id']);
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
                    $formatted_timestamp = 'Invalid Timestamp';
                }
        
                echo '<div style="position: relative; padding: 10px"> 
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="chat.php?receiver_ID=' . $row['user2_id'] . '&room_id=' . $row['chat_room_id'] . '">
                                <img src="../shop_owner/layout/images/logo/' . $shop_logo . '" alt="Avatar" style="border: 1px solid black;">
                                <strong>Chat with ' . $shop_name . '</strong>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <div style="position: absolute; top: 19px; right: 6px;">
                                <h5 style="font-size:13px">Start date: ' . $row['start_date'] . '</h5>
                            </div>
                            <a href="delete_room.php?roomid=' . $row['chat_room_id'] . '">
                                <div style="position: absolute; top: -10px; right: 8px;">
                                    <span><i class="fa-solid fa-xmark"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div style=" font-size: 12px;color: gray;"> last message: <span style="
                    font-weight: 900;">' . $last_message['message_text'] . '</span>     <br>' . $formatted_timestamp. '</div>
                    <hr>
                </div>';
            }
        }else {
            echo '<div style="text-align: center; margin: 207px auto;">No rooms found.</div>';
        }
        ?>
        </div>
    </div>




   <?php include($tmpl .'footer.php') ; //<!-- footer -->

}


//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>




