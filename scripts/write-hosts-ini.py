#!/usr/bin/env python3

import yaml
from yaml import Loader, Dumper

### Read server from site config
#
server = ""
with open("/site.yml", "r") as f:
    yaml_str = f.read()
    site_config = yaml.load(yaml_str, Loader=Loader)
    server = site_config['server']

### Construct hosts.ini content
#
hosts_ini = """[webserver]
{server}
""".format(server=server)

### Write hosts ini file
#
with open("hosts.ini", "w") as f:
    f.write(hosts_ini)
