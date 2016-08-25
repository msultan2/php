<?php
require_once "Mail.php";
 
$from = "CNP.VAS@vodafone.com";
$to = "Mahmoud.Ashraf-ElGammal@vodafone.com";
$subject = "Test email using PHP SMTP\r\n\r\n <p>ddddd</p>";
$body = "This is a test email message";

$host = "10.230.95.91";
$username = "cnpvas";
$password = "Sultan)000";
 
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
  'port'=>'25',
    'auth' => true,
    'username' => $username,
    'password' => $password));
 
$mail = $smtp->send($to, $headers, $body);
 
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
} else {
  echo("<p>Message successfully sent!</p>");
}
?>