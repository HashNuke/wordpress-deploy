## Configuration for wordpress-deploy

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