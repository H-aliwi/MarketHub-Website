<?php
// items tablomuzdaki item_name sütunua göre filtreleme yapıyoruz
$host = "localhost";
$dbname = "test";
$user = "root";
$pass = "";


try{
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass);
}catch(PDOException $e){
    echo '<strong>wlecom</strong> : ' . $e->getMessage();
    exit;
}

try{
    if(isset($_REQUEST["term"])){
        // only form start char
        // create prepared statement
        // $sql = "SELECT * FROM items WHERE item_name LIKE :term";
        // $stmt = $db->prepare($sql);
        // $term = $_REQUEST["term"] . '%';


        $sql = "SELECT * FROM items WHERE item_name LIKE CONCAT('%', :term, '%')" ;
        $stmt = $db->prepare($sql);
        $term = $_REQUEST["term"];
        $stmt->bindValue(":term", $term, PDO::PARAM_STR);
        // bind parameters to statement
        $stmt->bindParam(":term", $term);
        // execute the prepared statement
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){
                echo '<div class="element" style="margin-top:2px;">' . $row["item_name"] . '</div>';
            }
        } else{
            echo '<div class="element">No result found </div>';
        }
    }  
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

// Close statement
unset($stmt);
 
// Close connection
unset($db);
?>