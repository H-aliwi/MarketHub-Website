<?php

// add item
function showMessageBoxadd() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box-d");
        messageBox.classList.remove("hidden-m-d");
        setTimeout(function() {
            messageBox.classList.add("hidden-m-d");
            window.location.href = "items.php";
        }, 3000);
    </script>';
}
?>