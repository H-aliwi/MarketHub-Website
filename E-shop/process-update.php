<?php
session_start();
require("connection.php");
date_default_timezone_set("Asia/Bahrain");

$table = $_POST["tableN"];

if($table == 'admin'){
    $UID = 'adminID';
}
elseif($table == 'shop_owner'){
    $UID = 'Shop_OwnerID';
}
elseif($table == 'customer'){
    $UID ='CustomerID';
}
else{
    echo " error";
}

$token = $_POST["token"];

$token_hash = hash("sha256", $token);


$sql = "SELECT * FROM " . $table . "
        WHERE rest_hash = ?";

$stmt = $db->prepare($sql);

$stmt->bindParam(1, $token_hash, PDO::PARAM_STR);

$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user === null) {
    die("token not found");
}

if (strtotime($user["rest_exp"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE " . $table . "
        SET password = ?,
            rest_hash = NULL,
            rest_exp = NULL
        WHERE " . $UID . " = ?";

$stmt = $db->prepare($sql);

$stmt->bindParam(1, $password, PDO::PARAM_STR);
$stmt->bindParam(2, $user[$UID], PDO::PARAM_INT);

$stmt->execute();

echo "Password updated. You can now login.";

?>