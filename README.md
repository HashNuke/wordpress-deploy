# wordpress-deploy

> **NOTE:** This readme is being written before the project starts :) Please do not look for the code - does not exist.

> *🚀 Deploy wordpress sites to $5 servers in under a minute 🚀*

[Install](#install) | [Deploy a site](#deploy-a-site) | [Configuration](#configuration) | [FAQs](#faqs)

-----

In 2022, Wordpress is still really good for a lot of sites. The new Gutenberg full-site editor is 🔥 good. I hope this project helps you, just like it helps me host my sites.

* 😍 Easy to configure
* 💰 Budget-friendly setup. Stuff as many sites as you can on your $5 server.
* ♻️ Automatic daily/weekly backups
* 👮‍♀️ Server monitoring with email alerts
* ⛑ Wordpress update email alerts
* 🧯 Spam protection with fail2ban
* 💪 Firewall protection with `ufw`
* ⚡️ Pre-installs [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) for speed optimization
* 🧪 Tested on [DigitalOcean](https://www.digitalocean.com/), [Vultr](https://www.vultr.com/) and [AWS LightSail VPS](https://aws.amazon.com/lightsail/)

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

> Please follow the same order of instructions to avoid issues.

### [Step-1] Create a server with Ubuntu 20.04 (LTS) on your cloud provider

Ensure to choose SSH key as the authentication method and add the SSH key to your local SSH key agent.

```
ssh-add ~/.ssh/mykey
```

### [Step-2] Add DNS records

You need DNS records for the following:

#### Domain/subdomain for email notifications

* The backup emails, server alerts, etc, are sent out from your own server.
* For this to work, please point an A-record for any subdomain to the server's IP (example: `anything.example.com`)
* Make note of this domain/subdomain.

#### Domain/subdomain for the new website

* If your website will be served at `example.com`, then
  * Add an A-record pointing to `example.com` pointing to the server's IP
  * Add a CNAME record for `www.example.com` pointing to example.com
* If your website will be served at `blog.example.com`, then
  * Add an A record for `blog.example.com` pointing to the server's IP

### [Step-3] Add a server to the `hosts` file

Create a host file with the name of the server and IP address like below.

I've named my server as `personal`, but you can name it whatever.

```play
[personal]
1.2.3.4
```

### [Step-4] Create a config file in the `sites` dir

* Copy the sample configuration to create a config for your site.
* Please read the configuration file and set the values appropriately.

```
cp sites/sample.yml sites/mysite.yml
```

Refer to the [configuration section](#configuration) below for details about options.

### [Step-5] Deploy

```
ansible-playbook setup.yml --extra-vars @sites/mysite.yml
```

### [Step-6] Check the post-install notification email (DO NOT SKIP)

* You will receive an email from deployer@something about your site being setup successfully. Check your spam if you did not receive it.
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

#### `email_domain`

* What domain will this server use to send outgoing emails? We just need to look legit to other email servers.
* Configure any unused subdomain and add a DNS A record pointing to this server.
* If left unconfigured, then server notifications, email backups and wordpress update alerts will not be configured.
* Use the same config for all sites on the server.

```yaml
email_domain: "mailman.example.com"
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

### `php_version`

* We will update the PHP version once in a while, to the latest version that Wordpress can support.
* You can optionally set your own PHP version to something that is available in the official ubuntu repos.

```
php_version: "7.4"
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

#### Why are backups done with email?

This project is built to rely less on third-party services like storage clouds. Everyone has an email with some space.

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

#### Why use monit instead of systemd?

Need server and process monitoring, along with email notifications if something bad happens.

## License

```
Copyright (C) 2022 Akash Manohar John

Check the LICENSE file for more info.
```
