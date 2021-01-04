FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl


# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

# ========== @START
#
#
#
## First thing first Update the current container
#RUN apt-get update -y
#
## Setup Tzdata First, This will set container timezone
#ENV TZ='Asia/Kolkata'
#RUN DEBIAN_FRONTEND="noninteractive" apt-get -y install tzdata
#
## Add php repo provider https://packages.sury.org/php/README.txt
#RUN apt-get -y install apt-transport-https lsb-release ca-certificates curl
#RUN curl -sSL -o /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
#RUN sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
#RUN apt-get update
#
#
## Copy composer.lock and composer.json
#COPY composer.json /var/www/
#
## Install dependencies
#RUN apt-get update && apt-get install -y \
#    build-essential \
#    libpng-dev \
#    libjpeg62-turbo-dev \
#    libfreetype6-dev \
#    locales \
#    zip \
#    jpegoptim optipng pngquant gifsicle \
#    vim \
#    unzip \
#    git \
#    curl
#
#RUN apt-get install -yq php7.4 php7.4-fpm php7.4-curl php7.4-zip php7.4-pdo php7.4-zip php7.4-xml php7.4-intl php7.4-dom php7.4-mbstring
#
## Clear cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*
#
## Install extensions
##RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
##RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
##RUN docker-php-ext-install gd
#
## Install composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#
## Copy existing application directory contents
#COPY . /var/www
#
#RUN php composer.phar install -v
#
## Expose port 9000 and start php-fpm server
#EXPOSE 9000
#CMD ["php-fpm"]
#

# ========== @END