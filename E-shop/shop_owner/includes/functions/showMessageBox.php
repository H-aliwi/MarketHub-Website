<?php
// update item
function showMessageBox() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box");
        messageBox.classList.remove("hidden-m");
        setTimeout(function() {
            messageBox.classList.add("hidden-m");
            window.location.href = "items.php";
        }, 4000);
    </script>';
}


?>