# wordpress-deploy

> **NOTE:** This readme is being written before the project starts :) Please do not look for the code - does not exist.

> *🚀 Deploy wordpress sites to $5 servers in under a minute 🚀*

[Install](#install) | [Deploy a site](#deploy-a-site) | [Configuration options](docs/configuration.md) | [FAQs](docs/faqs.md)

-----

In 2022, Wordpress is still really good for a lot of sites. The new Gutenberg full-site editor is 🔥 good. I hope this project helps you, just like it helps me host my sites.

* 😍 Easy to configure
* 💰 Budget-friendly setup. Stuff as many sites as you can on your $5 server.
* ♻️ Automated daily backups + weekly backups by email.
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

### [Step-2] Add DNS records for domain/subdomains

* Domain/subdomain for the website.
* Domain/subdomain for email notifications (backup emails, alerts, etc). Add an A-record for this.

> These two can be the same domain/subdomain.

### [Step-3] Add a server to the `hosts` file

Create a `hosts` file with the name of the server and IP address like below. I've named my server as `personal`, but you can name it whatever.

```play
[personal]
1.2.3.4
```

### [Step-4] Create a config file in the `sites` dir

```
cp sites/sample.yml sites/mysite.yml
```

> The sample config file has details about configuration options. Give it a read.

### [Step-5] Deploy

```
ansible-playbook setup.yml -i hosts --extra-vars @sites/mysite.yml
```

> 👉 **[IMPORTANT]** You will receive an email with instructions after your server is setup. Please check your spam for this mail.

## More documentation

* [Configuration Options](docs/configuration.md)
* [FAQs](docs/faqs.md)

## License

```
Copyright (C) 2022 Akash Manohar John
Check the LICENSE file for more info.
```
