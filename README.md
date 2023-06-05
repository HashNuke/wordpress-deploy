# wordpress-deploy

[Install](#install) | [Deploy a site](#deploy-a-site) | [Configuration options](docs/configuration.md) | [FAQs](docs/faqs.md)

![Deploy wordpress sites to $5 servers in a few minutes](docs/intro-image.png)

-----

Use this to setup blogs for your family or landing pages for your side-projects. (*Hint: Gutenberg editor Full Site Editing is 🔥*)

* 😍 Easy to configure
* 💰 Budget-friendly setup. Stuff as many sites as you can on your $5 server.
* ♻️ Automated weekly backups by email + daily backups on server ([docs](docs/backups.md))
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

# 👇👇👇 Start a python virtual environment
pipenv shell

# 👆👆👆 Ensure to run the above command.
# Else your terminal will not find the "ansible-playbook" command.
```

## Deploy a site

> Please follow the same order of instructions to avoid issues.

### [Step-1] Create a server with Ubuntu 22.04 (LTS) on your cloud provider

Ensure to choose SSH key as the authentication method and add the SSH key to your local SSH key agent.

```
ssh-add ~/.ssh/mykey
```

### [Step-2] Add DNS records for domain/subdomains

* Domain/subdomain for the website.
* Domain/subdomain for email notifications (backup emails, alerts, etc). Add an A-record for this.

> These two can be the same domain/subdomain.

### [Step-3] Create a config file for the site

```
cp sites/sample.yml path/to/mysite.yml
```

> The sample config file has details about configuration options. Give it a read.

### [Step-4] Deploy

Now let's deploy this site the server `example.com`. You can also use an IP address like `1.2.3.4`

**PLEASE do not ignore the comma. Notice the value is "example.com," in the command below.**

```
ansible-playbook setup.yml \
-i "example.com," \
--extra-vars @/path/to/mysite.yml
```

### 👉 Login credentials + New site checklist 😃

The wordpress admin user will receive an email with login credentials for the admin user. This email also includes a checklist for your new site.

> **[IMPORTANT]** *If you do not find this email in your inbox, please check your spam folder. And if you still do not find it then check the instructions below the screenshot.*

![Post-install email with instructions](docs/images/post-install-email.png)

#### Find default password for admin user

If you do not get an email after setting up a new site, then you can still access the password for the admin user. The default password is stored as a file on the server.

Assuming your `site_name` is "mysite", your default wordpress admin password can be found at the following path on the server.

```
/sites/mysite/config/default-password
```

## More documentation

* [Configuration Options](docs/configuration.md)
* [Backups](docs/backups.md)
* [FAQs](docs/faqs.md)

## License

```
Copyright (C) from 2022 till date: Akash Manohar John
Check the LICENSE file for more info.
```
