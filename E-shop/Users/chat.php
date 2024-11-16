<?php
session_start();

if (isset($_SESSION['usernameA']) ) 
{    $NoFooter ="";

    $pageTitle = "Control Page";

    include("intil.php") ;  //<!--  rounter -->
    include("connection.php");


?>
<style>


    #chat-messages {
        height: 460px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;

    background-color: white;
    }

    #message-form input[type="text"] {
        width: 91%;
        padding: 5px;
        margin-top :3px;
    }

    #message-form button {
        padding: 5px 10px;
    }
    #chat-par {
        position: relative;
   
    }
    #select-option{
        position: absolute;
        top: 13px;
        right: 6px;
        font-size: 12px;
        color: black;
    }
    .selected {
            background-color:#dcdcddf5;
        }
       
        .msg-send {
        display: flex;
        align-items: baseline;
    }

    .msg-send input[type="text"],
    .msg-send button {
        margin-right: 5px;
    }
    
</style>
<!-- $sender_id= user_session   &&  $receiver_id=selsected user to chat -->


<?php 

$receiver_ID = isset($_GET['receiver_ID']) && is_numeric($_GET['receiver_ID'])  ? intval($_GET['receiver_ID']) : 0;
$room_ID = isset($_GET['room_id']) && is_numeric($_GET['room_id'])  ? intval($_GET['room_id']) : 0;

$sender_id=$_SESSION['UserID']; 
$receiver_id=$receiver_ID;
// 
$receiverID = $_GET['receiver_ID'];
$roomID = $_GET['room_id'];
// echo "receiver :".$receiverID ." %%%% room: ".$roomID ;
// 
?>


<div class="container" style="   max-width: 760px;
        margin: 0 auto;
        margin-top :15px;">


    <h2 class="text-center p-2 m-0 "style="background-color: #192a51; color:white; 
    font-size:25px;"> <a href="rooms.php" style="color:white"><span style="float: left;"><i class="fa-solid fa-arrow-left"></i></span> </a> 
      Chat Room</h2>



    <div id="chat-messages"></div>
    
    
    <form id="message-form">
    <div class="msg-send"> 

        <input type="text" id="message-input" name="message" placeholder="Type your message...">
        <input type="hidden" name="sender_id" value="<?php echo $sender_id ?> ">
        <input type="hidden" name="receiver_id" value="<?php echo $receiver_id?> ">
        <input type="hidden" name="room_ID" value="<?php echo $room_ID?> ">

        <button class="btn m-0" type="submit">Send</button>
        </div>

    </form>
</div>





<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        loadChatMessages();


        // send a message 
        $('#message-form').submit(function (e) {
            e.preventDefault();
            var message = $('#message-input').val();
            if (message.trim() !== '') {
                sendMessage(message);
                
                $('#message-input').val('');
                

            }
        });

        setInterval(function(){  loadChatRoom(); },
                     1111);

    
    });
    
  
 

    function loadChatMessages() {

        $.ajax({
            url: 'get_messages.php',
            type: 'GET',
            data: { receiverID: '<?php echo $receiverID; ?>', roomID: '<?php echo $roomID; ?>' },
            success: function (response) {
                $('#chat-messages').html(response);
                scrollChatToBottom();
            }
        });
    }
    function loadChatRoom() {
        $.ajax({
            url: 'load.php',
            type: 'GET',
            data: { receiverID: '<?php echo $receiverID; ?>', roomID: '<?php echo $roomID; ?>' },
            success: function (response) {
            $('#chat-messages').html(response);
            
            
            }
        });
    }

    function sendMessage(message) {
        $.ajax({
            url: 'send_message.php',
            type: 'POST',
            data: { message: message,
                sender_id: $('[name="sender_id"]').val(), // Retrieve sender_id value
                receiver_id: $('[name="receiver_id"]').val(), // Retrieve receiver_id value
                room_ID:$('[name="room_ID"]').val() // Retrieve room_ID value

            },
            success: function (response) {
                if (response === 'success') {
                    
                    loadChatMessages();
                    
                } else {
                    alert('Failed to send message.');
                }
            }
        });
    }

    function scrollChatToBottom() {
        var chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    
    </script>



<?php



    include($tmpl .'footer.php') ; //<!-- footer -->
    

}

//Redirect to login
else{echo"You are to authzied to enter this page";
header('location:index.php'); 
}
?>





