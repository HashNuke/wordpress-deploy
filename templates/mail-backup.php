<?php
$backups_path = "{{ site_backups_path }}";
$server_user = "{{deploy_user}}@{{domain}}";
$site_name = "{{site_name}}";
$mail_to = "{{ wordpress_admin_email }}";

$db_exports = glob("{$backups_path}/*.sql");
rsort($db_exports);
$full_backups = glob("{$backups_path}/*-ext.tar.gz");
rsort($full_backups);

if (count($db_exports) > 0 && count($full_backups) > 0){
  echo "Found a backup to email\n";

  $html_body  = "Hello";
  $html_body .= "<br/>";
  $html_body .= "<p>A database backup for the site {$site_name} has been attached along with this email.</p>";
  $html_body .= "<h3>Instructions to download an extended backup</h3>";
  $html_body .= "<p>A tarball of the database export and the uploads folder has also been generated on the server for you. You will find the backup at the following path.</p>";
  $html_body .= "<code>";
  $html_body .= $full_backups[0];
  $html_body .= "</code>";

  $html_body .= "<p>";
  $html_body .= "To download the tarball, run the below command from your computer.<br/>";
  $html_body .= "<pre>";
  $html_body .= "rsync -chavzP --stats {$server_user}:{$backups_path}/{$full_backups[0]} .";
  $html_body .= "</pre>";
  $html_body .= "</p>";

  $html_body .= "<hr/><p>";
  $html_body .= "This is a weekly email sent to you every Sunday 9am GMT.";
  $html_body .= "Daily backups are generated and available for upto 7 days on the server at the following directory<br/>";
  $html_body .= "<code>{$backups_path}</code>";
  $html_body .= "</p>";

  $handle = fopen($db_exports[0], "r");
  $content = fread($handle, filesize($db_exports[0]));
  fclose($handle);
  $encoded_content = chunk_split(base64_encode($content));

  $boundary = md5(bin2hex(random_bytes(10)));

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed;";
  $headers .= "boundary = $boundary\r\n";

  $mail_body = "--$boundary\r\n";
  $mail_body .= "Content-Type: text/html; charset=utf-8\r\n";
  $mail_body .= "Content-Transfer-Encoding: base64\r\n\r\n";
  $mail_body .= chunk_split(base64_encode($html_body));

  $filename = basename($db_exports[0]);
  $mail_body .= "--$boundary\r\n";
  $mail_body .="Content-Type: application/gzip; name=".$filename."\r\n";
  $mail_body .="Content-Disposition: attachment; filename=".$filename."\r\n";
  $mail_body .="Content-Transfer-Encoding: base64\r\n";
  $mail_body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
  $mail_body .= $encoded_content;

  $mail_subject = "[{$site_name}] ♻️ Wordpress site weekly backup";

  if(mail($mail_to, $mail_subject, $mail_body, $headers)){
    echo "Backup email has been sent.\n";
  } else {
    echo "Failed to send backup email.\n";
  }

} else {
  echo "Found no backup to mail\n";
}
?>
