<?php

session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if(isset($_POST['submitContact']))
{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
    


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '#';                     //SMTP username
    $mail->Password   = '#';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('#', 'Portfolio Contact');
    $mail->addAddress('#', 'Portfolio Contact');     //Add a recipient
    
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Portfolio Enquiry';
    $mail->Body    = "Sender Name - $name <br> Sender Email - $email <br> Message - $message";

    if($mail->send())
    {
        $_SESSION['status'] = "Thank for Contact Us";
        header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit(0);
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
else
{
    header('Location: contact.php');
    exit(0);
}
?>