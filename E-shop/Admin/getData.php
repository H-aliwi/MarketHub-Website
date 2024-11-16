<?php 
    session_start();
    require("connection.php");
    
    /* start shops part processing */
    if(isset($_POST['action1'])){
        $output = '';
        /* display the table of the shops */
        if($_POST['action1'] == 'fetchData'){
            $stmnt = $db->prepare("SELECT * FROM shop ORDER BY shopID DESC");
            getData1($stmnt);
        }

        // /*searching by shop details */
        // if($_POST['action1'] == 'searchRecord'){
        //     $shop_Name = $_POST['shop_Name'];
        //     if($shop_Name == ''){
        //         $stmnt = $db->prepare("SELECT * FROM shop ORDER BY shopID DESC");
        //         getData1($stmnt);
        //     }else{
        //     $stmnt = $db->prepare("SELECT * FROM shop WHERE shop_Name LIKE '%$shop_Name%' ORDER BY shopID DESC");
        //     getData1($stmnt);
        //     }
        // }

        // /* filter the items table */
        // if($_POST['action1'] == 'filtershops'){
        //     $filter_value1 = $_POST['filter_value1'];

        //     if($filter_value1 == 'filter'){
        //         $stmnt = $db->prepare("SELECT * FROM shop ORDER BY shopID DESC");
        //     }
        //     elseif($filter_value1 == 'Ascending'){
        //          $stmnt = $db->prepare("SELECT * FROM shop ORDER BY shopID ASC");
        //     }
        //     elseif($filter_value1 == 'Descending'){
        //         $stmnt = $db->prepare("SELECT * FROM shop ORDER BY shopID DESC");
        //     }
        //     // else{
        //     //     $query = $db->prepare("SELECT * FROM item WHERE Item_state LIKE '$filter_value' ORDER BY ItemID DESC");
        //     // }
        //     getData1($stmnt);
        // }

        /* Buttons process */

        /* Active button */
        // if($_POST['action'] == 'actItem'){
        //     $id = $_POST['id'];
        //     $query = $db->prepare("UPDATE item SET Item_state = 'Active' WHERE ItemID = '$id' ");
        //     getData($query);
        // }

        /* Verifying button */
        // if($_POST['action'] == 'verItem'){
        //     $id = $_POST['id'];
        //     $query = $db->prepare("UPDATE item SET Item_state = 'Verifying' WHERE ItemID = '$id' ");
        //     getData($query);
        // }

        /* Block button */
        // if($_POST['action'] == 'BlkItem'){
        //     $id = $_POST['id'];
        //     $query = $db->prepare("UPDATE item SET Item_state = 'Blocked' WHERE ItemID = '$id' ");
        //     getData($query);
        // }


    }

    function getData1($stmnt){
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
                    <td> <a href="shop_detalis.php?shopID='.$info['shopID'].'" style="
                    font-weight: 400;">'.$info['shop_Name'].'</a></td>
                    <td> <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 500px;">'.$info['shop_Description'].'</p></td>
                    <td> '.$info['payment_Information'].'</td>
                    <td> '.$info['rate'].'</td>
                    
                </tr>
                ';
            }
        }
        else{
            $output .= '<tr><td colspan="5"> No shop(s) found...</td></tr>';
        }
        echo $output;

    }
    /* End shops part processing */



    /* start items part processing */
    if (isset($_POST['action'])) {

        // Buttons process
        
        if ($_POST['action'] == 'actItem') {
            $id = $_POST['id'];
            $query = $db->prepare("UPDATE item SET Item_state = 'Active', Admin_feedback = '' WHERE ItemID = '$id' ");
            $query->execute();
        }
        // Display the table of items
        $query = $db->prepare("SELECT * FROM item ORDER BY ItemID DESC");
        getData($query);
    }

    function getData($query){
        require("connection.php");

        $output = '';
        
        $query -> execute();
        $rows = $query->fetchAll();
        

        
        if(count($rows) > 0){
            $i = 0;
            foreach ($rows as $info){
                $i++;
                $output .='
                <tr>
                    <td> '.$i.'</td>
                    <td><img src="../shop_owner/layout/images/items/'.$info['Item_image'].'" alt="Description of the image" style="width: 55px;" "></td>
                    <td> 
                    <a href="item_detalis.php?itemID='.$info['ItemID'].'" style="
                    font-weight: 400;">'.$info['Title'].'</a></td>
                    <td> '.$info['List_date'].'</td>
                    <td> '.$info['Item_state'].'</td>
                    <td> '.$info['Price'].'</td>
                    <td> <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 305px;">'.$info['Item_description'].'</p></td>
                    <td> '.$info['Quantity'].'</td>
                    <td style="display: flex; justify-content: space-around;">
                    
                        <button type="button" class="btn btn-success" id="actItem" style="margin-right: 5px;" data-val='.$info['ItemID'].'>
                        <i class="fa-solid fa-check"></i>
                        </button>

                        <button type="button" class="btn btn-danger BlkItem" id="BlkItem" style="margin-right: 5px;" data-val='.$info['ItemID'].'>
                        <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                        
                        <button type="button" class="btn btn-warning verItem" id="verItem" data-val='.$info['ItemID'].'>
                        <i class="fa-solid fa-spinner"></i>
                        </button>
                        
                    </td>
                </tr>
                ';
            }
        }
        // elseif($rows<0){
        //     $output = "<tr><td colspan='8'> No item(s) found...</td></tr>";
        // }
        else{
            $output .= '<tr><td colspan="8"> No item(s) found...</td></tr>';
        }
        echo $output;

    }
    /* End items part processing */
?>



