# wordpress-deploy

> **NOTE:** This readme is being written before the project starts :) Please do not look for the code - does not exist.

> *🚀 Deploy wordpress sites to $5 servers in under a minute 🚀*

In 2022, Wordpress is still really good for a lot of sites. The new Gutenberg full-site editor makes Wordpress a hard-to-beat option for self-hosting any site. I hope this project helps you, just like it helps me host my sites.

* 😍 Easy to configure
* 💰 Budget-friendly setup - works just fine on a $5 server
* ♻️ Automatic daily/weekly backups
* ⚡️ Optimized wordpress sites with [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) and [Jetpack Boost](https://wordpress.org/plugins/jetpack-boost)
* 👮‍♀️ Pre-configured monitoring notifications for the server
* ⛑ Email alerts with instructions for Wordpress updates
* 🧯 Spam protection with fail2ban
* 💪 Firewall protection with `ufw`
* 👪 Supports multiple sites per server

## Install

Install python3 and clone this repository.

```
git clone https://github.com/HashNuke/wordpress-deploy.git wordpress-deploy
cd wordpress-deploy

# Install pipenv
pip3 install pipenv

# Install python dependencies
pipenv install

# Start the python virtual environment
pipenv shell
```

> This project uses Ansible, hence the python dependencies.

## Deploy a site

> Everytime you deploy a site ensure to start a shell using `pipenv shell`

#### Step-0: Create a server anywhere and add SSH key to agent

Create a server running Ubuntu on any cloud provider. Ensure to choose SSH key as the authentication method.

Assuming you can login to the new server with the `mykey` SSH key, add the key to the SSH agent for the next steps.
```
# Add the key to your SSH Agent for further use.
# This will have to be done on every system restart :)
ssh-add ~/.ssh/mykey
```

This project has been tested on:
* [DigitalOcean](https://www.digitalocean.com/) - Starts at $6/month
* [Vultr](https://www.vultr.com/) - Starts at $2.5/month (look for the "Regular Performance" VPS)
* [AWS LightSail VPS](https://aws.amazon.com/lightsail/) - Starts at $3.5/month

> Whatever server/provider you use, beware of additional bandwidth costs if your site is famous or redditted.

### Step-1: Add a server to the `hosts` file

Create a host file with the name of the server and IP address like below.

I've named my server as `personal`, but you can name it whatever.

```play
[personal]
1.2.3.4
```

### Step-2: Create a config file in the `sites` dir

Copy the sample configuration to create a config for your site.

```
cp sites/sample.yml sites/mysite.yml
```

Refer to the configuration section below for options.

### Step-3: Deploy

```
ansible-playbook setup.yml --extra-vars @sites/mysite.yml
```

### Step-4: Add notification email to your email contacts

**DO NOT SKIP THIS STEP**

* You will receive an email from deployer@something about your site being setup successfully.
* Please add this to your contacts so that you do not miss this email.

This email is coming from the server you just setup. You will get a backup of your site every 7 days.

## Configuration

The supported configuration for sites is listed below. Create a file with your site's nickname like `sites/mysite.yml` with the below configuration.

```
# Edit the configuration options below to pick something that works best for your site.
#
# For details about configuration options, please check the readme on GitHub readme.
# https://github.com/HashNuke/wordpress-deploy

### Servers
#
# Which server to use for this site? Check the "hosts" file in the repository.
# Default value uses "personal"
#
server: personal

### Domains
#
# Mandatory. No default value.
# This is where you will access your site.
# Ensure to assign add appropriate DNS records to the domain.
# For more information checkout the project readme.
#
domain: "example.com"

### Redirect domain
#
# Not mandatory. No default value.
# This option is to support redirection from another domain to the primary domain.
# Ensure to add appropriate DNS records to the domain.
#
redirect_domain: "www.example.com"

### Email domain
#
# What email will this server use to send outgoing emails?
# Configure any unused subdomain and add a DNS A record pointing to this server.
# We just need to look legit to other email servers.
# Use the same config for all sites on the server.
#
outgoing_email_domain: "mailman.example.com"

### Notification email
#
# Not mandatory. No default value.
# If the blog server goes down and cannot be restarted, this address will receive a notification.
# If this is not set, then server notifications will not be configured.
#
notify_email: "your-email@example.com"

### Backup email
#
# Not mandatory. No default value.
# This is the address to which site backups are sent. If not configured, then backups will not be sent.
#
backup_email: "your-email@example.com"

### Backup interval
#
# Not mandatory. If backup email is configured, then default backup interval is every Sunday 9am IST.
# This is the address to which site backups are sent. If not configured, then backups will not be configured.
#
# Examples:
# Use "0 9 * * *" for backups everyday at 9am IST.
# Use "0 9 * * 0" for backups every Sunday at 9am IST 
#
# Refer to https://crontab.guru/ to choose a valid cron schedule.
#
backup_interval: "0 9 * * 0"

### Wordpress version
#
# By default, the latest wordpress version is installed.
# If notifications are enabled, you will receive an email when there is a new wordpress update.
#
wordpress_version: "latest"
```

## FAQs

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
