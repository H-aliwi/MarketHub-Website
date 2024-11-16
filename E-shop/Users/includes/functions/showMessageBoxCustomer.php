
<?php
// update item
function showMessageBoxCustomer() {
    echo '
    <script>
        var messageBox = document.getElementById("message-box-cus");
        messageBox.classList.remove("hidden-cus");
        setTimeout(function() {
            messageBox.classList.add("hidden-cus");
        }, 5000);
    </script>';
}


?>