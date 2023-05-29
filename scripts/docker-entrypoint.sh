#!/usr/bin/env bash

python3 /app/scripts/write-hosts-ini.py
echo "\n==> Inventory file:"
cat hosts.ini
echo "\n==> Running Ansible playbook..."

ansible-playbook -i hosts.ini --extra-vars @/site.yml $@
