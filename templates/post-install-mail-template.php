<?php

function does_point_to_server($fqdn) {
  $domain_ips = gethostbynamel("www.wpd-test.akash.im");
  if ($domain_ips == false) {
    return false;
  }

  $output=null;
  $retval=null;
  exec("hostname -I", $output, $retval);
  $hostnames = explode(" ", $output[0]);
  $server_ip = $hostnames[0];

  if(in_array($server_ip, $domain_ips)) {
    return true;
  } else {
    return false;
  }
}
?>

<p>
Hello fellow human,
<br/>
Your new site "{{ site_title }}" has been setup to be served at <a href="https://{{ domain }}">https://{{ domain }}</a>.
</p>
<p>
Your login credentials are mentioned in the section below. Please take some time to read this email.
</p>


<h2>🧪 New site checklist</h2>

<h3>👉 Add this email address to your email contacts ({{deploy_user}}@{{email_domain}})</h3>
<p>
This will ensure that your email provider does not mark these emails as spam. These are emails from your own server.
</p>

<h3>👉 Set a new admin password</h3>
<h4>
  Wordpress admin url: <a href="https://{{domain}}/wp-admin">https://{{domain}}/wp-admin</a>
  <br/>
  Username: <code>{{ wordpress_admin_user }}</code>
  <br/>
  Password: <code>{{ default_wordpress_password }}</code>
</h4>

<p>
a new "{{deploy_user}}" user with the same SSH keys as the default user has been setup on the server.
<br/>
So you should be able to login to the server as "{{deploy_user}}" and run the below command to get the password that has been set for you:<br/>
<code>cat /home/{{deploy_user}}/sites/{{site_name}}/config/default-password</code>
</p>

<h3>✅ DNS record for email notifications ({{ email_domain }})</h3>
<p>
The A-record for {{ email_domain }} was added in the DNS appropriately. Your emails will work fine. No action required.
</p>


<?php
if (does_point_to_server("{{ domain }}")) {
?>
  <h3>✅ DNS record for domain ({{ domain }})</h3>
  <p>
    Found a DNS record for the {{ domain }} pointing to a server. No action required.
  </p>
<?php
} else {
?>
  <h3>❌ DNS record for domain ({{ domain }})</h3>
  <p>
    Please ensure to set a DNS record for {{ domain }} to point to the server's IP address.
    <br/>
    If you have already added it, do not worry, it might take a while to propagate through the internet.
  </p>
<?php
}
?>


<?php
if ("{{ redirect_domain }}" != "") {
  if (does_point_to_server("{{ redirect_domain }}")) {
  ?>
    <h3>✅ DNS record for redirect domain ({{ redirect_domain }})</h3>
    <p>
      Found DNS record pointing to {{ redirect_domain }}. No action required.
    </p>
  <?php
  } else {
  ?>
    <h3>❌ DNS record for redirect domain ({{ redirect_domain }})</h3>
    <p>
      Please ensure to set a DNS record for {{ redirect_domain }} to point to the server's IP address.
      <br/>
      If you have already added it, do not worry, it might take a while to propagate through the internet.
    </p>
  <?php
  }
}
?>

<h3>✅ Backups configured</h3>
<p>
  Database backups of the wordpress site will be mailed to {{wordpress_admin_email}} every Sunday at 9am GMT.
  <br/>
  Daily backups are also generated and stored on the server for 7 days. There are also extended backups that include the database export and the uploads folder.
  <br/>
  You will find the backups at the following path on the server.
  <br/>
  <code>{{ site_backups_path }}</code>
</p>

<hr/>

<h2>❤️ Loved using this project?</h2>
<p>Here are some things you could do:</p>

<ul>
  <li>
    Tweet <a href="https://twitter.com/HashNuke">@HashNuke</a> to let me know about your new site. I would love to hear about them.
  </li>
  <li>
    Please share this project with other people - <a href="https://github.com/HashNuke/wordpress-deploy">https://github.com/HashNuke/wordpress-deploy</a>
  </li>
</ul>

<h2>👋 Enjoy your new site</h2>
<p>And again, don't forget to reset your password 🙏</p>
