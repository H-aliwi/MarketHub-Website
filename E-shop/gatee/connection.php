<?php
//$dbhost="localhost";
$dsn ='mysql:host=localhost;dbname=markethub';

$dbuser="root";
$dbpass="";
//$dbname="markethub";

$option = array(
PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',

);


try{

    $con =new PDO($dsn ,$dbuser,$dbpass,$option);
    $con -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e){
    echo  'Failed To Connect'.$e->getMessage();
}
// $conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

// if(!$conn){
//     die("You are not connected to DB".mysqli_connect_error());
// }
?>