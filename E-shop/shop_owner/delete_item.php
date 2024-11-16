
<?php

if (isset($_POST['delete_item'])) {
    include("connection.php");

    $item_id= $_POST['item_id'];

    $query = "DELETE FROM item WHERE ItemID= ?";
    $stmt = $con->prepare($query);

    $stmt->execute(array($item_id));

    if ($stmt) {
              $_SESSION['show_message_del'] = true;
              header("Location: items.php");
        }else {
        echo "<script>alert(' ERROR in deleting .')</script>";}

    
        }
    

?>