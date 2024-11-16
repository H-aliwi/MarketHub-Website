<?php

// delete item
function showMessageBoxDel() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box-del");
        messageBox.classList.remove("hidden-m-del");
        setTimeout(function() {
            messageBox.classList.add("hidden-m-del");
            window.location.href = "items.php";
        }, 3000);
    </script>';
}
?>