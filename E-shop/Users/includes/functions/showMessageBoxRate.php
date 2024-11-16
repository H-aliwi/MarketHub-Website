<?php
// update item
function showMessageBoxRate() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box-rate");
        messageBox.classList.remove("hidden-rate");
        setTimeout(function() {
            messageBox.classList.add("hidden-rate");
        }, 4000);
    </script>';
}


?>