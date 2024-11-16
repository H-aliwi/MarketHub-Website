<?php 
    session_start();
    require("connection.php");
    
    
    /* start shops part processing */
    if(isset($_POST['action'])){
        $output = '';

        // if($_POST['action'] == 'DelivOrd'){
        //     $id = $_POST['id'];
        //     $stmnt = $db->prepare("UPDATE shop_order SET Delivered_date = NOW(), IsDelivered = 'Yes' WHERE Order_ID = '$id' ORDER BY shop_order.shopID DESC");
        //     $stmnt->execute();
        // }

        // if($_POST['action'] == 'NotDelivOrd'){
        //     $id = $_POST['id'];
        //     $stmnt = $db->prepare("UPDATE shop_order SET Delivered_date = NULL, IsDelivered = 'NO' WHERE Order_ID = '$id' ORDER BY shop_order.shopID DESC");
        //     $stmnt->execute();
        // }

        /* display the table of the shops */
        $stmnt = $db->prepare("SELECT * FROM shop_order JOIN shop ON shop_order.shopID = shop.shopID ORDER BY shop_order.shopID DESC");
        getData($stmnt);

    }

    function getData($stmnt){
        require("connection.php");

        $output = '';
        
        $stmnt -> execute();
        $rows = $stmnt->fetchAll();
        
        if(count($rows) > 0){
            $i = 0;
            foreach ($rows as $info){
                $i++;
                $output .='
                <tr>
                    <td> '.$i.'</td>
                    <td> '.$info['Order_ID'].'</td>
                    <td> '.$info['IsDelivered'].'</td>
                    <td> '.$info['Delivered_date'].'</td>
                    <td style="display: flex; justify-content: space-around;">
                    
                    <a href="OrderInfo.php?orderID='.$info['Order_ID'].'"> 
                    <button type="submit" class="btn-o editebtn" 
                    style="padding: 5px;display: flex;border-radius: 10%;justify-content: center;align-items: center;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                      </button> 
                    </a>

                    </td>
                </tr>
                ';
            }
        }
        else{
            $output .= '<tr><td colspan="6"> No item(s) found...</td></tr>';
        }
        echo $output;

    }

?>