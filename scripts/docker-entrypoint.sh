#!/usr/bin/env bash

python3 /app/scripts/write-hosts-ini.py
echo "\n==> Inventory file:"
cat hosts.ini
echo "\n==> Running Ansible playbook..."

chmod 666 /run/host-services/ssh-auth.sock

ansible-playbook -i hosts.ini --extra-vars @/site.yml $@
