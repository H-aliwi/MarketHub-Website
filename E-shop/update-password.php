<?php
session_start();
require("connection.php");
date_default_timezone_set("Asia/Bahrain");
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$table = null; // Initialize the variable


$sql1 = "SELECT COUNT(*) as count FROM admin WHERE rest_hash = :rth";
$stmnt1 = $db->prepare($sql1);
$stmnt1->bindParam(':rth', $token_hash);
$stmnt1->execute();
$result1 = $stmnt1->fetch();
if ($result1['count'] > 0) {
    $table = 'admin';
}

$sql2 = "SELECT COUNT(*) as count FROM shop_owner WHERE rest_hash = :rth";
$stmnt2 = $db->prepare($sql2);
$stmnt2->bindParam(':rth', $token_hash);
$stmnt2->execute();
$result2 = $stmnt2->fetch();
if ($result2['count'] > 0) {
    $table = 'shop_owner';
}

$sql3 = "SELECT COUNT(*) as count FROM customer WHERE rest_hash = :rth";
$stmnt3 = $db->prepare($sql3);
$stmnt3->bindParam(':rth', $token_hash);
$stmnt3->execute();
$result3 = $stmnt3->fetch();
if ($result3['count'] > 0) {
    $table = 'customer';
}

if ($table) {

$sql = "SELECT * FROM " . $table . "
        WHERE rest_hash = ?";

$stmt = $db->prepare($sql);

$stmt->bindParam(1, $token_hash, PDO::PARAM_STR);

$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user === null) {
    die("Token not found");
}

if (strtotime($user["rest_exp"]) <= time()) {
    die("Token has expired");
}
// 

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>Reset Password</h1>

    <form method="post" action="process-update.php">

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <input type="hidden" name="tableN" value="<?php echo $table; ?>">
        
        <label for="password">New password</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Confirm password</label>
        <input type="password" id="password_confirmation"
               name="password_confirmation">

        <button type="submit">Send</button>
    </form>

</body>
</html>

<?php
}
else{
    echo "Please check you'r email agian";
}
?>