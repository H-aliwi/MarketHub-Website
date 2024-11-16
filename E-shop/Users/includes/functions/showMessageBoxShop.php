
<?php
// update item
function showMessageBoxShop() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box-shop");
        messageBox.classList.remove("hidden-shop");
        setTimeout(function() {
            messageBox.classList.add("hidden-shop");
        }, 6000);
    </script>';
}


?>