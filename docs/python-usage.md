# Install & use project using Python

## Setup project

Install python3 and clone this repository.

```shell
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

Complete steps 1-3 in the readme and then follow the next section.

### Run the command below to deploy

Assuming your site configuration file is `hello.yml`, run the below command to setup your site.

```shell
ansible-playbook -i localhost, --extra-vars @hello.yml setup.yml
```

## Destroy a site

Assuming your site configuration file is `hello.yml`, run the below command to setup your site.

```shell
ansible-playbook -i localhost, --extra-vars @hello.yml destroy.yml
```
