<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require("connection.php");

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

date_default_timezone_set("Asia/Bahrain");
$expiry = date("Y-m-d H:i:s", time() + 60 * 60);


$sql1 = "SELECT COUNT(*) as count FROM admin WHERE Email = :eml";
$stmnt1 = $db->prepare($sql1);
$stmnt1->bindParam(':eml', $email);
$stmnt1->execute();
$result1 = $stmnt1->fetch();
if ($result1['count'] > 0) {
    $table = 'admin';
}

$sql2 = "SELECT COUNT(*) as count FROM shop_owner WHERE Email = :eml";
$stmnt2 = $db->prepare($sql2);
$stmnt2->bindParam(':eml', $email);
$stmnt2->execute();
$result2 = $stmnt2->fetch();
if ($result2['count'] > 0) {
    $table = 'shop_owner';
}

$sql3 = "SELECT COUNT(*) as count FROM customer WHERE Email = :eml";
$stmnt3 = $db->prepare($sql3);
$stmnt3->bindParam(':eml', $email);
$stmnt3->execute();
$result3 = $stmnt3->fetch();
if ($result3['count'] > 0) {
    $table = 'customer';
}





if ($table) {
    
$sql = "UPDATE " . $table . "
        SET rest_hash = ?,
        rest_exp = ?
        WHERE email = ?";

$stmt = $db->prepare($sql);

$stmt->bindParam(1, $token_hash, PDO::PARAM_STR);
$stmt->bindParam(2, $expiry, PDO::PARAM_STR);
$stmt->bindParam(3, $email, PDO::PARAM_STR);

$stmt->execute();


if ($stmt->rowCount() > 0) {

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'hasanalsheek2009@gmail.com';                     //SMTP username
        $mail->Password   = 'ntaqnakfcmuvqexb';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($email, 'Mailer');
        $mail->addAddress($email);     //Add a recipient
        

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Change your password';
        $mail->Body = <<<END

        To reset your password click <br>
        <a href="http://localhost/E-shop/update-password.php?token=$token">here</a> 
        

    END;

        $mail->send();
        echo "Message sent, please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
}
else{
    echo "No matching email found in any table.";
}


?>