<?php 
$NoNavbar = "";
include("intil.php");  //<!-- router -->


?>
<style>
    .container {
        max-width: 760px;
        margin: 0 auto;
        margin-top :15px;


    }

    #chat-messages {
        height: 460px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;

    background-color: white;
    }

    #message-form input[type="text"] {
        width: 90%;
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
       
    
</style>
<!-- $sender_id= user_session   &&  $receiver_id=selsected user to chat -->

<?php 
$sender_id=2; 
$receiver_id=1;
?>
<section name="navbar"> 
    
    <nav class="navbar navbar-expand-md  navbar-light">
    <a class="navbar-brand" href="#">
        <span style="    color: red;
        font-weight: 400;
        font-size: 22px; ">SBE</span><span style="font-weight: 200;
        font-size: 22px;" >Shop</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
        <ul  class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;">
        <li class="nav-item ">
            <a class="nav-link" href="">Home<span class="sr-only" >(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Catogeries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="rooms.php">Chats</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Posts</a>
        </li>
     
        </ul>


        <ul class="navbar-nav ml-auto  my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;margin-right: 70px;">
        <li class="nav-item_2 dropdown ">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            About us
            </a>
            
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Contact us</a></li>
            <li><a class="dropdown-item" href="#">FQS</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">team members</a></li>
            </ul>
        </li>

        </ul>
        

    </div>
        
    </nav>


</section>
<div class="container">


<h2 class="text-center p-2 m-0 "style="background-color: #192a51; color:white; font-size:25px;">Chat Room</h2>

    <div id="chat-messages"></div>
    
    <form id="message-form">
        <input type="text" id="message-input" name="message" placeholder="Type your message...">
        <input type="hidden" name="sender_id" value="<?php echo $sender_id ?> ">
        <input type="hidden" name="receiver_id" value="<?php echo $receiver_id?> ">
        <button type="submit">Send</button>
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

    
        
        setInterval(function(){
            loadChatRoom();
        }, 1111);
    

    });
    function loadChatRoom() {
        $.ajax({
            url: 'load.php',
            type: 'GET',
            success: function (response) {
            $('#chat-messages').html(response);
            
            }
        });
    }
 

    function loadChatMessages() {
        $.ajax({
            url: 'get_messages.php',
            type: 'GET',
            success: function (response) {
                $('#chat-messages').html(response);
                scrollChatToBottom();
            }
        });
    }

    function sendMessage(message) {
        $.ajax({
            url: 'send_message.php',
            type: 'POST',
            data: { message: message,
                sender_id: $('[name="sender_id"]').val(), // Retrieve sender_id value
                receiver_id: $('[name="receiver_id"]').val() // Retrieve receiver_id value
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

include($tmpl . 'footer.php'); //<!-- footer -->
?>