<?php

$datetime = new DateTime('tomorrow');
$tomorrowDate= $datetime->format('Y-m-d');

session_start();
require './mailsending/PHPMailerAutoload.php';

if(isset($_GET['Notify'])==true&&$_GET['Notify']=="true"){
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->Host = '10.230.95.91';  // Specify main and backup SMTP servers
$mail->Host = '10.230.95.91';
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'cnpvas';                 // SMTP username
$mail->Password = 'Sultan!111';                           // SMTP password
$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('CNP.VAS@vodafone.com');

$mail->addAddress('SMVoiceDemand@voda.com'); 
$mail->addCC('Mohamed.ELmasry@vodafone.com');
$mail->addCC('Mohamed.Ali-AbulEla@vodafone.com'); 
//$mail->addCC('Mahmoud.Ashraf-ElGammal@vodafone.com');   // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('mohamed.sultan@vodafone.com', 'CNP VAS');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//<img src="http://egoct-wipsd01/csi/678.jpg"/> 
//$mail->addAttachment('C:\wamp\www\CSI\678.jpg');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'BSS Team Activities Upload Notification ( '.$tomorrowDate.')';
$mail->Body    = 'From :'.$_SESSION["Username"].'</br>Dear All </br>
Please note that the BSS team has finished uploading activities to the Activities DB </br>
Dear TX SDM </br>
Please Upload TX activities and Send the conflict report </br>
Best Regards </br>
';
$mail->AltBody = 'Dear All 
Please note that the BSS team has finished uploading activities to the Activities DB 
Dear TX SDM 
Please Upload TX activities and Send the conflict report 
Best Regards 
';
if(!$mail->send()) {

    echo 'failed';

} else {
    echo 'sent';
}
}///end sending Message notify 
else if((isset($_GET['send'])==true&&$_GET['send']=="true")){
$CRQ =$_GET['CRQ'];
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->Host = '10.230.95.91';  // Specify main and backup SMTP servers
$mail->Host = '10.230.95.91';
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'cnpvas';                 // SMTP username
$mail->Password = 'Sultan!111';                           // SMTP password
$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('CNP.VAS@vodafone.com');
 
$mail->addAddress('SMVoiceDemand@voda.com'); 
$mail->addCC('Mohamed.ELmasry@vodafone.com');
$mail->addCC('Mohamed.Ali-AbulEla@vodafone.com');
//$mail->addAddress('Mahmoud.Ashraf-ElGammal@vodafone.com');  //$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('mohamed.sultan@vodafone.com', 'CNP VAS');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//<img src="http://egoct-wipsd01/csi/678.jpg"/> 
//$mail->addAttachment("http://egoct-wipsd01/csi/data/9999999table3.jpg");   
 
//$mail->addAttachment("C:\\wamp\\www\\CSI\\data\\".$CRQ."totalinfo.xls");  
//$mail->addAttachment('C:\wamp\www\CSI\678.jpg');         // Add attachments
      // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
if($CRQ=="")
$mail->Subject = 'Activity Card:Activity Log';
else 
$mail->Subject = 'Activity Card:'.$CRQ.' At '.$tomorrowDate;

 
$mail->Body    = ' <div>From :'.$_SESSION["Username"].'</br> Dear All ,

Please find below the Activity Card of  '.$CRQ.' & (Impact and Activity STSs are highlighted)
</br>

<img src="cid:my-photo" alt="my-photo" />.

<img src="http://egoct-wipsd01/csi/data/'.$CRQ.'impactedSitesPerBSC.jpg"/> </br><img src="http://egoct-wipsd01/csi/data/'.$CRQ.'table1.jpg"/> </br><img src="http://egoct-wipsd01/csi/data/'.$CRQ.'table2.jpg"/></br> 
 Best Regards
 </br>
</div>
 
 
 ';
 //$mail->addAttachment("C:\\wamp\\www\\CSI\\data\\".$CRQ."ListOfSites.jpg");
 $mail->addAttachment("C:\\wamp\\www\\CSI\\data\\".$CRQ."Sites.xls"); 
 
 //$mail->AddEmbeddedImage("C:\\wamp\\www\\CSI2\\data\\".$CRQ."ListOfSites.jpg");
 //$mail->AddEmbeddedImage("C:\\wamp\\www\\CSI2\\data\\".$CRQ."ListOfSites.jpg", 'my-photo', 'my-photo.jpg ');
 
// <img src="http://egoct-wipsd01/csi/data/'.$CRQ.'table3.jpg"/>
$mail->AltBody = 'Dear All 
Please note that the BSS team has finished uploading activities to the Activities DB 
Dear TX SDM 
Please Upload TX activities and Send the conflict report 
Best Regards 
';

if(!$mail->send()) {
echo "failed";
    //echo 'Message could not be sent.';
   // echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
echo"sent";    //echo 'Message has been sent';
}




}else if(isset($_GET['TXNotify'])==true&&$_GET['TXNotify']=="true"){

//check the conflicts 
 $MismatchReportDate=$tomorrowDate; 

require('MismatchOutput.php');ob_clean();
$count=count($SitesArrayResult);
if($count>0)$SitesConflictsNumber=$count;else $SitesConflictsNumber="0";
$count=count($HubArrayResult);
if($count>0)$HubsConflictsNumber=$count;else $HubsConflictsNumber="0";
$count=count($NodesArrayResult);
if($count>0)$NodesConflictsNumber=$count;else $NodesConflictsNumber="0";
$count=count($CoverageArrayResult);
if($count>0)$CoverageConflictsNumber=$count;else $CoverageConflictsNumber="0";
$count=count($TXDuplicationArrayResult);
if($count>0)$TXDuplicationConflictsNumber=$count;else $TXDuplicationConflictsNumber="0";
$count=count($BSSDuplicationArrayResult);
if($count>0)$BSSDuplicationConflictsNumber=$count;else $BSSDuplicationConflictsNumber="0";

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->Host = '10.230.95.91';  // Specify main and backup SMTP servers
$mail->Host = '10.230.95.91';
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'cnpvas';                 // SMTP username
$mail->Password = 'Sultan!111';                           // SMTP password
$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('CNP.VAS@vodafone.com');

$mail->addAddress('SMVoiceDemand@voda.com'); 
$mail->addCC('Mohamed.ELmasry@vodafone.com');
$mail->addCC('Mohamed.Ali-AbulEla@vodafone.com'); 
//$mail->addCC('Mahmoud.Ashraf-ElGammal@vodafone.com'); 
     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('mohamed.sultan@vodafone.com', 'CNP VAS');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//<img src="http://egoct-wipsd01/csi/678.jpg"/> 
//$mail->addAttachment('C:\wamp\www\CSI\678.jpg');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'TX-BSS Conflicting Activities  Report ( '.$tomorrowDate.')';
$mail->Body    = 'From :'.$_SESSION["Username"].'</br> Dear Team</br></br>

Please note that the all TX, BSS activities are uploaded and conflict analysis report is ready , please check the I-Matrix portal</br>
</br>
1. Sites conflicts :'.$SitesConflictsNumber.' conflicts </br></br>
2. Hub conflicts : '.$HubsConflictsNumber.' conflicts</br></br>
3. Nodes conflicts : '.$NodesConflictsNumber.' conflicts</br></br>
4. Coverage Area conflicts :'.$CoverageConflictsNumber.' conflicts </br></br>
5. BSS Duplications :'.$BSSDuplicationConflictsNumber.' conflicts</br></br>
6. TX Duplications: '.$TXDuplicationConflictsNumber.' conflicts</br></br>
To check The Portal  
http://egoct-wipsd01/csi/MismatchOutput.php </br></br>
Best Regards </br></br>
';
$mail->AltBody = 'From :'.$_SESSION["Username"].'</br> Dear Team

Please note that the all TX, BSS activities are uploaded and conflict analysis report is ready , please check the I-Matrix portal”

1. Sites conflict : There is a Site level conflict found, please check portal .// no conflict detected 
2. Hub conflict : There is a Hub level conflict found, please check portal .// no conflict detected 
3. Nodes conflict : There is a BSS Node level conflict found, please check portal .// no conflict detected 
4. Coverage Area conflict : There is a Coverage Area level conflict found, please check portal .// no conflict detected 

Best Regards 

';
if(!$mail->send()) {
    echo 'failed';

} else {
    echo 'sent';
}
















}//end txnotify 
else if(isset($_GET['TXNotifyBSS'])==true&&$_GET['TXNotifyBSS']=="true"){
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->Host = '10.230.95.91';  // Specify main and backup SMTP servers
$mail->Host = '10.230.95.91';
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'cnpvas';                 // SMTP username
$mail->Password = 'Sultan!111';                           // SMTP password
$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('CNP.VAS@vodafone.com');
 
$mail->addAddress('SMVoiceDemand@voda.com'); 
$mail->addCC('Mohamed.ELmasry@vodafone.com');
$mail->addCC('Mohamed.Ali-AbulEla@vodafone.com');
//$mail->addCC('Mahmoud.Ashraf-ElGammal@vodafone.com');    // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('mohamed.sultan@vodafone.com', 'CNP VAS');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//<img src="http://egoct-wipsd01/csi/678.jpg"/> 
//$mail->addAttachment('C:\wamp\www\CSI\678.jpg');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'TX Team Activities Upload Notification ( At '.$tomorrowDate.')';
$mail->Body    = 'From  '.$_SESSION["Username"].'</br>Dear All </br>
Please note that the TX team has finished uploading activities to the Activities DB </br>
Dear BSS SDM </br>
Please Upload BSS activities and Send the conflict report </br>
Best Regards </br>
';
$mail->AltBody = 'From :'.$_SESSION["Username"].'</br>Dear All 
Please note that the BSS team has finished uploading activities to the Activities DB 
Dear TX SDM 
Please Upload TX activities and Send the conflict report 
Best Regards 
';

if(!$mail->send()) {
    echo 'failed';
  
} else {
    echo 'sent';
}
}///end sending Message notify 