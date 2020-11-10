#!/usr/bin/env bash

git stash
git checkout .
git reset clean -fd
git reset --hard HEAD
git pull --rebase

php data/load_db.php
rm -rf public/blog
rm -rf data/cache/*.php

php laminas phly-blog:compile