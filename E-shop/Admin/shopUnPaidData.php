<?php 
    session_start();
    require("connection.php");
    include('includes/functions/getAdminUsernameById.php');
    include('includes/functions/getShopName.php');


/* payment for Not paid processing */
    if(isset($_POST['action'])){
        $output = '';

        
        /* display the table of the shops */
        $stmnt1 = $db->prepare("SELECT * , SUM(Paid_price) AS total_paid_price FROM shop_payment WHERE IsPaid = 'Yes' GROUP BY shopID");
        getData1($stmnt1);

    }

    function getData1($stmnt1){
        require("connection.php");

        $output = '';
        
        $stmnt1 -> execute();
        $rows1 = $stmnt1->fetchAll();
        
        if(count($rows1) > 0){
            $i = 0;
            foreach ($rows1 as $info1){
                $result = $info1['total_paid_price'] * 0.04;
                $IR = number_format($result, 3);
                
                $amount = $info1['total_paid_price'] - $IR;
                $AmAfDe = number_format($amount, 3);



                $adminID = $info1['paid_admin_ID'];
                $un = getAdminUsernameById($adminID);

                $shopID = $info1['shopID'];
                $shopName = getShopName($shopID);


                $i++;
                $output .='
                <tr>
                    <td> '.$i.'</td>
                    <td> '.$shopName.'</td>
                    <td> '.$un.'</td>
                    <td> '.$info1['IsPaid'].'</td>
                    <td> '.$info1['Paid_date'].'</td>
                    <td> '.$info1['total_paid_price'].'</td>
                    <td> '.$IR.'</td>
                    <td> '.$AmAfDe.'</td>
                    
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