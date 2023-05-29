#!/usr/bin/env bash

python3 /app/scripts/write-hosts-ini.py
echo ""
echo "==> Inventory file:"
cat hosts.ini
echo ""
echo "==> Running Ansible playbook..."

ansible-playbook -i hosts.ini --extra-vars @/site.yml $@
