<?php
// ob_start();
session_start();
if (isset($_SESSION['usernameA'])) {

    $pageTitle = "Favorat items";
    $NoFooter ="";



    include("connection.php");


if (isset($_GET['action']) && $_GET['action'] == "delete") {
    
      $cookie_data = stripslashes($_COOKIE['Favorate']);
      $Fav_data = json_decode($cookie_data, true);
      foreach($Fav_data as $keys => $values)
      {
       if($Fav_data[$keys]['item_id'] == $_GET["id"])
       {
        unset($Fav_data[$keys]);
        $item_data = json_encode($Fav_data);
        setcookie("Favorate", $item_data, time() + (86400 * 120));
        header("location:Favorat_list.php?remove=1");


       }
      }
     }

     if (isset($_GET['action']) && $_GET['action'] == "clearAll") {
        {
            setcookie("Favorate", "", time() - 3600);
            header("location:Favorat_list.php?clearall=1");
        } 
       }

   
       include("intil.php");
       include('includes/functions/showMessageBox.php');
?>


<style>

</style>

<!-- Add your HTML code here -->

<div class="container">

    <table class="table table-bordered table-striped mt-3 text-center mr-10" style="
    background-color: white;">
        <tr>
            <td colspan="6" style="background-color: #d0d5db00; color: black; font-style: normal; font-weight: bold;">
                <h2 class="text-center">Favorite Items</h2>
            </td>
        </tr>
        <tr>
            <th>Product image</th>
            <th>Product Name</th>
            <th>Product price</th>
            <th>shopID</th>
            <th>Action</th>

        </tr>
        <?php
        $total = 0;
        if (isset($_COOKIE['Favorate'])) {
            $Fav_data = json_decode($_COOKIE['Favorate'], true);

            foreach ($Fav_data as $keys =>$values) {
                echo '
                <tr>
                    <td><img src="../shop_owner/layout/images/items/' . $values['item_img'] . '" alt="" style="width:120px;"></td>
                    <td>' . $values['item_name'] . '</td>
                    <td>' . $values['item_price'] . '</td>
                    <td>' . $values['shopID'] . '</td>

                    <td>
                        <a href="Favorat_list.php?action=delete&id=' . $values['item_id'] . '">

                        <button type="submit" class="btn-danger" 
                        style="padding: 2px 5px;border-radius: 6px;">
                        <i class="fa-solid fa-trash-can"></i>

                       </button> 
                        
                        </a>
                    </td>
                </tr>';

            }
        } else {
            echo '
            <tr>
                <td colspan="6" style="
                    background-color: #d0d5db00;
                    color: #bd2130;
                    font-style: normal;
                    font-weight: bold;">
                    Your Favorate list is Empty !!! Add now
                </td>
            </tr>';
        }
        ?>
        <tr>
            <td colspan="4"></td>
            <td>
                <a href="Favorat_list.php?action=clearAll">
                    <button class="btn-warning" style="border-color: #ffc107; padding: 10px; border-radius: 5px;">Clear All</button>
                </a>
            </td>
        </tr>
    </table>


</div>

<?php include($tmpl . 'footer.php'); //<!-- footer ?>

<?php
} else {
    echo "You are unauthorized to enter this page";
    header('location:index.php');
}
?>

