<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

if (isset($_POST['email'])) {

    $emailTo = $_POST['email']; 
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    $code = uniqid(true); // true for more uniqueness 
    $query = mysqli_query($con,"INSERT INTO resetPasswords (code, email) VALUES('$code','$emailTo')"); 
    if (!$query) {
       exit('Error'); 
    }
    try {
        //Server settings
        $mail->SMTPDebug = 0;     // Enable verbose debug output, 1 for produciton , 2,3 for debuging in devlopment 
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'confident.ye@gmail.com';                 // SMTP username
        $mail->Password = '774881466!';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;   // for tls                                 // TCP port to connect to
        // $mail->Port = 465;

        //Recipients
        $mail->setFrom('confident.ye@gmail.com', 'Conf'); // from who? 
        $mail->addAddress($emailTo, 'Joe User');     // Add a recipient

        $mail->addReplyTo('no-replay@example.com', 'No Replay');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Content
        // this give you the exact link of you site in the right page 
        // if you are in actual web server, instead of http://" . $_SERVER['HTTP_HOST'] write your link 
        $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/resetPassword.php?code=$code"; 
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your password reset link';
        $mail->Body    = "<h1> you requested password reset </h1>
                         Click <a href='$url'>this link</a> to do so";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    exit(); // to stop user from submitting more than once 
}

?>

<form method="post">
    <input type="email" name="email" placeholder="Email" autocomplete="off">
    <br>
    <input type="submit" name="submit" value="Reset Email">
</form>






