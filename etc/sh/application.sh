#!/bin/bash

# Goto application directory
cd /var/www/html

# Copy application environemtn config file
cp /root/env/production.env .env

# Remove application generated cache file(s)
rm -rf public/blog data/cache/*.php

#compile blog.
php laminas phly-blog:compile

#Exist the script
echo "[DONE] application.sh"
exit 0