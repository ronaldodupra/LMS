<?php 

$mail = new PHPMailer();                                 // Enable verbose debug output
$mail->isSMTP();
//$mail->SMTPDebug = 4;
$mail->Debugoutput = 'html';  
$mail->isHTML(true); 
$mail->Host = 'tls://smtp.gmail.com:587';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'lmsgreathome@gmail.com';                 // SMTP username
$mail->Password = 'greathome@2017';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->SMTPOptions = array(
'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
);

?>