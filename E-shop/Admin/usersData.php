<?php 
    session_start();
    require("connection.php");
    include('includes/functions/getAdminUsernameById.php');


    /* start owner shop part processing */
    if (isset($_POST['action'])) {

        // Button Active user process
        
        if ($_POST['action'] == 'actuser') {
            $id = $_POST['id'];
            $stmnt = $db->prepare("UPDATE shop_owner SET Shop_owner_state = 'Active', admin_feedback = '', adminID = NULL WHERE Shop_OwnerID = '$id' ");
            $stmnt->execute();
        }
        /* display the table of the owner shop */
        $stmnt = $db->prepare("SELECT * FROM shop_owner ORDER BY Shop_OwnerID DESC");
        //$stmnt->execute();
        getData($stmnt);
    }
    

    function getData($stmnt){
        require("connection.php");

        $output = '';
        
        $stmnt -> execute();
        $rows = $stmnt->fetchAll();
        
        if(count($rows) > 0){
            $x = 0;
            foreach ($rows as $info){
                $adminID = $info['adminID'];
                $AUsername = getAdminUsernameById($adminID);
                
                $x++;
                $output .='
                <tr>
                    <td> '.$x.'</td>
                    <td> '.$info['Username'].'</td>
                    <td> '.$info['Email'].'</td>
                    <td> '.$info['Shop_owner_state'].'</td>
                    <td> '.$info['admin_feedback'].'</td>
                    <td> '.$AUsername.'</td>
                    <td style="display: flex; justify-content: space-around;">
                    
                        <button type="button" class="btn btn-success" id="actuser" style="margin-right: 5px;" data-val='.$info['Shop_OwnerID'].'>
                        <i class="fa-solid fa-check"></i>
                        </button>

                        <button type="button" class="btn btn-danger Blkuser" id="Blkuser" style="margin-right: 5px;" data-val='.$info['Shop_OwnerID'].'>
                        <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                        
                        <button type="button" class="btn btn-warning veruser" id="veruser" data-val='.$info['Shop_OwnerID'].'>
                        <i class="fa-solid fa-spinner"></i>
                        </button>
                        
                    </td>
                                        
                </tr>
                ';
            }
        }
        else{
            $output .= '<tr><td colspan="7"> No user(s) found...</td></tr>';
        }
        echo $output;

    }
    /* End owner shop part processing */

    /* start customers part processing */
    if(isset($_POST['action1'])){
        $output = '';

        if ($_POST['action1'] == 'actCus') {
            $Cusid = $_POST['Cusid'];
            $stmnt1 = $db->prepare("UPDATE customer SET Customer_state = 'Active', admin_feedback = '', adminID = NULL WHERE CustomerID = '$Cusid' ");
            $stmnt1->execute();
        }
        /* display the table of the customers */
            $stmnt1 = $db->prepare("SELECT * FROM customer ORDER BY CustomerID DESC");
            CUData($stmnt1);
    }

    function CUData($stmnt1){
        require("connection.php");

        $output = '';
        
        $stmnt1 -> execute();
        $rows = $stmnt1->fetchAll();
        
        if(count($rows) > 0){
            $i = 0;
            foreach ($rows as $info){
                $i++;
                $output .='
                <tr>
                    <td> '.$i.'</td>
                    <td> '.$info['Username'].'</td>
                    <td> '.$info['Email'].'</td>
                    <td> '.$info['fullname'].'</td>
                    <td> '.$info['gender'].'</td>
                    <td> '.$info['age'].'</td>
                    <td> '.$info['Customer_state'].'</td>
                    <td> '.$info['Admin_feedback'].'</td>
                    <td style="display: flex; justify-content: space-around;">
                    
                        <button type="button" class="btn btn-success actCus" id="actCus" style="margin-right: 5px;" data-val='.$info['CustomerID'].'>
                        <i class="fa-solid fa-check"></i>
                        </button>

                        <button type="button" class="btn btn-danger BlkCus" id="BlkCus" style="margin-right: 5px;" data-val='.$info['CustomerID'].'>
                        <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                        
                        <button type="button" class="btn btn-warning verCus" id="verCus" data-val='.$info['CustomerID'].'>
                        <i class="fa-solid fa-spinner"></i>
                        </button>
                        
                    </td>
                                        
                </tr>
                ';
            }
        }
        else{
            $output .= '<tr><td colspan="8"> No user(s) found...</td></tr>';
        }
        echo $output;

    }
    /* End customers part processing */