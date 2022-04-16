# wordpress-deploy

> **NOTE:** This readme is being written before the project starts :) Please do not look for the code - does not exist.

> *🚀 Deploy wordpress sites to $5 servers in under a minute 🚀*

[Install](#install) | [Deploy a site](#deploy-a-site) | [Configuration](#configuration) | [FAQs](#faqs)

-----

In 2022, Wordpress is still really good for a lot of sites. The new Gutenberg full-site editor is 🔥 good. I hope this project helps you, just like it helps me host my sites.

* 😍 Easy to configure
* 💰 Budget-friendly setup. Stuff as many sites as you can on your $5 server.
* ♻️ Automatic weekly backups
* 💪 Firewall protection with `ufw`
* ⚡️ Pre-installs [WP Super Cache](https://wordpress.org/plugins/wp-super-cache/) for speed optimization
* 🧪 Tested on [DigitalOcean](https://www.digitalocean.com/)
* ⛑ Wordpress update email alerts *(👨‍💻 Coming soon)*
* 👮‍♀️ Server monitoring with email alerts *(👨‍💻 Coming soon)*

> You still need to enable disk backups with your cloud provider.

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

```
##########
### Site details (mandatory)

# site_name is the name of the folder where your site will be created.
# It must be unique on the server.
# Please do limit this to letters, numbers, underscores and hyphens.
site_name: mysite

# site_title is the name of the wordpress site
site_title: "Hello World"

##########
### Server details (mandatory)

# Which server to use for this site? Check the "hosts" file in the repository.
# Default value uses "personal"
#
server: personal

# What is the default user for the server? Notes below to help you.
#
# If you use DigitalOcean, the default user is "root"
# If you use a Canonical image on AWS, the default user is "ubuntu"
#
default_user: root

##########
### Primary and redirect domains

# Primary domain (Mandatory. No default value)
# This is where you will access your site.
# Ensure to add appropriate DNS records to the domain.
#
domain: "example.com"

# Redirect domain (Not mandatory. No default value)
# This option is to support redirection from another domain to the primary domain.
# Ensure to add appropriate DNS records to the domain.
#
redirect_domain: "www.example.com"

##########
### Wordpress admin user details

# This will be the username of the Wordpress admin user.
wordpress_admin_user: "admin"

# This will be the email of the admin user.
# This email also will be used for notifications and backups.
wordpress_admin_email: "john@example.com"

##########
### Wordpress version

# By default, the latest wordpress version is installed.
wordpress_version: "latest"

##########
### Domain for email notifications
#
# What email will this server use to send outgoing emails?
# Configure any unused subdomain and add a DNS A record pointing to this server.
# We just need to look legit to other email servers.
# Use the same config for all sites on the server.
#
email_domain: "mailman.example.com"

#########
# PHP version

# You don't need to set this. We will update the version once in a while.
# php_version: "7.4"
```

## FAQs

#### What email notifications are sent?

For now, the email notifications are only for backups.

[👨‍💻Coming soon] The recipient configured in `notify_email` will be notified when the following scenarios occur:
* When the server disk space is 80% filled
* When the server memory is at 80% utilization
* When nginx or fastcgi is down
* When there is a new wordpress version

#### How to restore backups?

The backups emailed to you are SQL backups.
* Lookup on how to restore a MySQL/MariaDB database.
* The files in `wp-content/uploads` folder are not part of the backups. These would most likely be large to be sent over email. Please ensure to enable disk backups on your cloud provider.

As much as I would love to improve backups and backup restoration, I am also limited by time.

#### Why not use Kubernetes, Docker, etc?

This project is designed to be budget-friendly. I wanted to setup something small for my family and my hobby projects.

#### How to update Wordpress version?

[Coming soon 👨‍💻] The plan is to notify you via email about new wordpress versions for any sites that are outdated.

## License

```
Copyright (C) 2022 Akash Manohar John

Check the LICENSE file for more info.
```
