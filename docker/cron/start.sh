#!/bin/bash

# To export the environment variables of the docker container into a cron environment
# Refer: https://stackoverflow.com/a/48651061/278851
declare -p | grep -Ev 'BASHOPTS|BASH_VERSINFO|EUID|PPID|SHELLOPTS|UID' > /container.env

echo "Installing Crontab..." 
crontab /etc/cron.d/crontab 
cron -f