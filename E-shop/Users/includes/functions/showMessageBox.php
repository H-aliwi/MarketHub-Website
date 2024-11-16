
<?php
// update item
function showMessageBox() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box");
        messageBox.classList.remove("hidden");
        setTimeout(function() {
            messageBox.classList.add("hidden");
        }, 3000);
    </script>';
}


?>