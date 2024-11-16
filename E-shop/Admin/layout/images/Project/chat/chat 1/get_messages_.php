
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


// Establish database connection
include("connection.php");
$stat = $con->prepare("SELECT * FROM messages WHERE chat_room_id = ? ORDER BY timestamp ASC");

$stat->execute(array(1));

// Display messages
if ($stat->rowCount() > 0) {
    while ($row = $stat->fetch()) {
        $sender = $row['sender_id'];
        $message = $row['message_text'];
        $timestamp = $row['timestamp'];

        echo '<div class="content" data-content="' . $row['msg_id'] . '">
                <div style="position: relative;">
                    <strong>'.$sender.'</strong>: '.$message. 
                    '<p style="font-size: 11px;">'.$timestamp.'</p>
                    <hr>
                </div>
               </div>
        
        ';
       
    }
    echo ' 
    <div id="effect-options" style="display: none; ">
    <div class="form-group">
      <label for="effect">Select an effect:</label>
      <select id="effect" class="form-control"style="width: 75%; ">
        <option value="">Select an effect</option>
        <option value="delete">Delete</option>
      </select>
    </div>
    <button id="apply-effect" class="btn btn-primary">Apply Effect</button>
    <button id="cancel-selection" class="btn btn-secondary">Cancel</button>
  </div>
  <div id="selected-content" style="display: none;">
    <p>Selected Content ID:</p>
    <div id="content-display"></div>
  </div>';
?>


<?php

 
} else {
    echo
    '<div style="text-align: center;
    margin: 207px auto;">  No messages found. </div>';
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script>
        $(document).ready(function() {
            $(".content").on("click", function() {
                var selectedContent = $(this).attr("data-content");
                $("#content-display").text(selectedContent);

                $(".content").removeClass("selected");
                $(this).addClass("selected");

                $("#effect-options").show();
                $("#selected-content").show();
            });

            $("#cancel-selection").on("click", function() {
                $(".content").removeClass("selected");
                $("#effect-options").hide();
                $("#selected-content").hide();
            });
            $("#apply-effect").on("click", function() {
                    var selectedEffect = $("#effect").val();
                    var selectedContent = $(".content.selected").attr("data-content");

                    //  if (selectedEffect === "hide") {
                    //     $(".content.selected").hide();
                    // } else if (selectedEffect === "show") {
                    //     $(".content.selected").show();
                 
                     if (selectedEffect === "delete") {
                        $.ajax({
                            url: 'delete_message.php', // Replace with the actual filename of your PHP script
                            type: 'POST',
                            data: { msg_id: selectedContent },
                            success: function(response) {
                                // Handle the response from the PHP script
                                console.log(response);
                                $(".content.selected").remove(); // Remove the deleted message from the DOM
                                $("#effect-options").hide();
                                $("#selected-content").hide();
                                alert("Message has been deleted successfully.");
                            },
                            error: function(xhr, status, error) {
                                // Handle any errors that occurred during the AJAX request
                                console.error(error);
                            }
                        });
                    }
                });

        });
    </script>