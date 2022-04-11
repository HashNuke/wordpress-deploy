# wordpress-deploy

> **NOTE:** This readme is being written before the project starts :) Please do not look for the code - does not exist.

> *🚀 Deploy wordpress sites to $5 servers in under a minute 🚀*

In 2022, Wordpress is still really good for a lot of sites. The new Gutenberg full-site editor is ⭐️⭐️⭐️⭐️⭐️. I hope this project helps you, just like it helps me host my sites.

* 😍 Easy to configure
* 💰 Budget-friendly setup - works just fine on a $5 server
* ♻️ Automatic daily/weekly backups
* ⚡️ Optimized wordpress sites with [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) and [Jetpack Boost](https://wordpress.org/plugins/jetpack-boost)
* 👮‍♀️ Pre-configured monitoring notifications for the server
* ⛑ Email alerts with instructions for Wordpress updates
* 🧯 Spam protection with fail2ban
* 💪 Firewall protection with `ufw`
* 👪 Supports multiple sites per server

**This project has been tested on:**

* [DigitalOcean](https://www.digitalocean.com/) - Starts at $6/month
* [Vultr](https://www.vultr.com/) - Starts at $2.5/month (look for the "Regular Performance" VPS)
* [AWS LightSail VPS](https://aws.amazon.com/lightsail/) - Starts at $3.5/month

## Install

Install python3 and clone this repository.

```
git clone https://github.com/HashNuke/wordpress-deploy.git wordpress-deploy
cd wordpress-deploy

# Install pipenv
pip3 install pipenv

# Install python dependencies
pipenv install

# Start a python virtual environment
pipenv shell
```

## Deploy a site

### [Step-0] Create an Ubuntu server on your cloud provider

Ensure to choose SSH key as the authentication method and add the SSH key to your local SSH key agent.

```
ssh-add ~/.ssh/mykey
```

### [Step-1] Add a server to the `hosts` file

Create a host file with the name of the server and IP address like below.

I've named my server as `personal`, but you can name it whatever.

```play
[personal]
1.2.3.4
```

### [Step-2] Create a config file in the `sites` dir

Copy the sample configuration to create a config for your site.

```
cp sites/sample.yml sites/mysite.yml
```

Refer to the [configuration section](#configuration) below for details about options.

### [Step-3] Deploy

```
ansible-playbook setup.yml --extra-vars @sites/mysite.yml
```

### [Step-4] Add notification email to your email contacts (DO NOT SKIP)

* You will receive an email from deployer@something about your site being setup successfully.
* Please add this to your contacts so that you do not miss this email.

This email is coming from the server you just setup. You will get a backup of your site every 7 days.

## Configuration

The supported configuration for sites is listed below. Create a file with your site's nickname like `sites/mysite.yml` with the below configuration.

#### `server` (mandatory)

Pick a server name from the `hosts` file you created earlier.

```yaml
server: personal
```

#### `domain` (mandatory)

* This is where you will access your site.
* Ensure to assign add appropriate DNS records to the domain.

```yaml
domain: "example.com"
```

#### `redirect_domain`

* This option is to support redirection from another domain to the primary domain.
* This is especially useful if you have a `www.example.com` that you also want to work as `example.com`.
* If you specify this option, ensure to add an appropriate DNS record.

```yaml
redirect_domain: "www.example.com"
```

#### `outgoing_email_domain`

* What domain will this server use to send outgoing emails? We just need to look legit to other email servers.
* Configure any unused subdomain and add a DNS A record pointing to this server.
* If left unconfigured, then server notifications, email backups and wordpress update alerts will not be configured.
* Use the same config for all sites on the server.

```yaml
outgoing_email_domain: "mailman.example.com"
```

#### `notify_email`

* Email address to send backups, wordpress alerts, server alerts, etc.
* IF not set, the above functionality will not work.

```yaml
notify_email: "your-email@example.com"
```

#### `backup_interval`

* Default backup interval is every Sunday 9am IST.
* You can set it to "off" if you do not want backups to be emailed.
* Examples:
  * Use `0 9 * * *` for backups everyday at 9am IST.
  * Use `0 9 * * 0` for backups every Sunday at 9am IST.
* Refer to https://crontab.guru/ to choose a valid cron schedule.

```yaml
backup_interval: "0 9 * * 0"
```

#### `wordpress_version`

* By default, the latest wordpress version is installed.
* If notifications are enabled, you will receive an email when there is a new wordpress update.

```yaml
# Use latest
wordpress_version: "latest"

# Or set it to a specific version
wordpress_version: "5.9.3"
```


## FAQs

#### What email notifications are sent?

The recipient configured in `notify_email` will be notified when the following scenarios occur:
* When the server disk space is 80% filled
* When the server memory is at 80% utilization
* When nginx or fastcgi is down
* When there is a new wordpress version

#### What will the backup email look like?

The first email that is sent after the site setup contains the site's first backup. That is what the backup email will look line.

#### Why are daily backups configured as an email?

Because everyone has an email with some space. Integration with Dropbox/GoogleDrive is hard enough for an opensource hobby project. We will not be integrating other backup methods.

#### What if my email inbox is being polluted with backups?

Here are some options:
* You can use GitHub Actions for custom backups. Refer to the backup script in TODO about how to perform a backup.
* Reduce the frequency of backups.

#### Why not use Kubernetes, Docker, etc?

* This project is designed to be budget-friendly.
* As for Kubernetes, cloud providers charge separately for control-plane, a persistent volume, and underlying servers. Most sites for putting up landing pages or family blogs do not require such fancy infra.

#### How to update Wordpress version?

Once a week, your server will email you about any sites that are running on outdated wordpress versions.
Instructions for updating wordpress versions are on the TODO page.

#### Why is monit used instead of systemd?

Need server and process monitoring, along with email notifications if something bad happens.
