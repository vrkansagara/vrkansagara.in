#!/bin/bash

add-apt-repository ppa:ondrej/php -y

for VERSION in 7.2 7.4;do
    for EXTENSION in fpm common curl gd dom intl mbstring ;do
        apt install php${VERSION}-${EXTENSION} -y
    done
done


cp /root/config/php/7.2/www.conf  /etc/php/7.2/fpm/pool.d/www.conf
cp /root/config/php/7.4/www.conf  /etc/php/7.4/fpm/pool.d/www.conf

# Get Composer, and install to /usr/local/bin
if [ ! -f "/usr/local/bin/composer" ];then
    echo "Installing composer"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
else
    echo "Updating composer"
    /usr/local/bin/composer self-update -q --stable --no-ansi --no-interaction
fi

php composer.phar install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader -vvv
# php composer.phar install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader -vvv
php laminas phly-blog:compile

echo "[DONE] php-installation.sh"
exit 0