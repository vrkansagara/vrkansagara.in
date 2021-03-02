#!/bin/bash

export DEBIAN_FRONTEND=noninteractive

for VERSION in 7.4;do
    for EXTENSION in fpm common curl dom intl mbstring gd gmp imagick mysqli sqlite3;do
        apt install php${VERSION}-${EXTENSION} -y
    done
done

echo "[DONE] php-installation.sh"
exit 0