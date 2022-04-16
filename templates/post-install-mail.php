<?php
ob_start();
include "post-install-mail-template.php";
$mail_body = ob_get_clean();

$mail_to = "{{ wordpress_admin_email }}";
$mail_subject = "Your new wordpress site 😃";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if(mail($mail_to, $mail_subject, $mail_body, $headers)){
  echo 'Post-install email has been sent.';
  touch("post-install-mail.state");
}else{ 
  echo 'Failed to send post-install email.';
}
?>