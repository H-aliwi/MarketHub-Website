<?php 
    session_start();
    require("connection.php");
    include('includes/functions/getShopName.php');
    if (isset($_SESSION['adminID'])) {
        $AID = $_SESSION['adminID'];

    }
    
    
    /* payment for paid processing */
    if(isset($_POST['action'])){
        $output = '';

        if($_POST['action'] == 'ShPaid'){
            $id = $_POST['id'];
            $stmnt = $db->prepare("UPDATE shop_payment SET IsPaid = 'Yes', paid_admin_ID = $AID WHERE shopID = :shopID");
            $stmnt->bindParam(':shopID', $id);
            $stmnt->execute();
        }

        // if($_POST['action'] == 'NotDelivOrd'){
        //     $id = $_POST['id'];
        //     $stmnt = $db->prepare("UPDATE shop_order SET Delivered_date = NULL, IsDelivered = 'NO' WHERE Order_ID = '$id' ORDER BY shop_order.shopID DESC");
        //     $stmnt->execute();
        // }

        /* display the table of the shops */
        $stmnt = $db->prepare("SELECT * , SUM(Paid_price) AS total_paid_price FROM shop_payment WHERE IsPaid = 'No' GROUP BY shopID");
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
                $result = $info['total_paid_price'] * 0.04;
                $IR = number_format($result, 3);
                
                $amount = $info['total_paid_price'] - $IR;
                $AmAfDe = number_format($amount, 3);

                $shopID = $info['shopID'];
                $shopName = getShopName($shopID);


                $i++;
                $output .='
                <tr>
                    <td> '.$i.'</td>
                    <td> '.$shopName.'</td>
                    <td> '.$info['IsPaid'].'</td>
                    <td> '.$info['total_paid_price'].'</td>
                    <td> '.$IR.'</td>
                    <td> '.$AmAfDe.'</td>
                    <td style="display: flex; justify-content: space-around;">
                    
                        <button type="button" class="btn btn-success Paid" id="Paid" style="margin-right: 5px;" data-val='.$info['shopID'].'>
                        <i class="fa-solid fa-check"></i>
                        </button>


                    </td>
                </tr>
                ';
            }
        }
        else{
            $output .= '<tr><td colspan="7"> No item(s) found...</td></tr>';
        }
        echo $output;

    }

?>