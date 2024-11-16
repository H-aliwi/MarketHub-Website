<?php
session_start();
require("connection.php");

$CName = $_POST["CName"];
$CEmail = $_POST["CEmail"];
$CTitle = $_POST["CTitle"];
$CDescription = $_POST["CDescription"];
$CTime = $_POST["CTime"];


//start send data to the email


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'hasanalsheek2009@gmail.com';                     //SMTP username
    $mail->Password   = 'ntaqnakfcmuvqexb';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($CEmail, $CName);
    $mail->addAddress('hasanalsheek2009@gmail.com');     //Add a recipient
   


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $CTitle;
    $mail->Body    = "From : " . $CEmail . "<br><br>" . "<b>".$CDescription."</b>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


// end of sending data to the email


// start enter data in database


$sql = "INSERT INTO contact_form (Send_date, Sender_name, Sender_email, title, description) 
            VALUES (:Ctime, :Cname, :Cemail, :Ctitle, :Cdescription)";

$stmt = $con->prepare($sql);

$stmt->bindParam(':Ctime', $CTime, PDO::PARAM_STR);
$stmt->bindParam(':Cname', $CName, PDO::PARAM_STR);
$stmt->bindParam(':Cemail', $CEmail, PDO::PARAM_STR);
$stmt->bindParam(':Ctitle', $CTitle, PDO::PARAM_STR);
$stmt->bindParam(':Cdescription', $CDescription, PDO::PARAM_STR);


if ($stmt->execute()) {
    $_SESSION['show_message_newForm'] = true;
    header("Location:contact_form.php");
    exit(); 
} 
else {
    echo "<script>alert('unable to send the request please try again.');</script>";
    header("Location: contact_form.php");
}

// end enter data to the database

?>