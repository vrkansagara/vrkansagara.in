# Close all = docker rm -vf $(docker ps -a -q)
# Remove all = docker rmi -f $(docker images -a -q)
# Remove everything  = docker system prune -a --volumes
# Docker clean everything  = docker rm -vf $(docker ps -a -q) && docker rmi -f $(docker images -a -q) && docker system prune -a --volumes -y
# Docker build image = docker build . -f .docker/vrkansagara.docker  --force-rm  -q -t vrkansagara:latest
# Docker run image in detach mode    = docker run --publish 8090:80 --detach --name vrkansagara vrkansagara:latest
# Docker run image = docker run --publish 8090:80 --name vrkansagara vrkansagara:latest
# Docker refresh image = docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q) && docker run --publish 8090:80 --detach --name vrkansagara vrkansagara:latest
# Docker run container  =  docker exec -it <CONTAINER ID> /bin/bash
# lsof -iTCP -sTCP:LISTEN -Pn
# RUN means it creates an intermediate container,
# ENTRYPOINT means your image (which has not executed the script yet) will create a container, and runs that script.
#  docker logs --tail 50 --follow --timestamps  webserver
# docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' container_name_or_id
# docker-compose build . -t vrkansagara_in:latest --parallel --no-rm  --memory --compress
FROM debian:stable-slim

## Setup Tzdata First(container image timezone), This will set container timezone
ENV TZ='Asia/Kolkata'
ARG DEBIAN_FRONTEND=noninteractive

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html


#Copy all shell scritp to /root/sh folder.
COPY etc /root/etc

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
    wget \
    curl \
    supervisor \
    tzdata \
    && sed -i 's/^\(\[supervisord\]\)$/\1\nnodaemon=true/' /etc/supervisor/supervisord.conf

#Other utility stuff
#RUN DEBIAN_FRONTEND="noninteractive" && apt install -y lsof htop vim git net-tools elinks gpg software-properties-common


# run defined shell script
RUN chmod +x /root/etc/sh/* \
    && /root/etc/sh/deb-sury-org.sh \
    && /root/etc/sh/php-installation.sh


# Download composer as project dependecies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet


## Make sure current container has super-user
USER root

# Clear system level cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Expose port 9000 and start php-fpm server
EXPOSE 9000

# Define default command.(this will start the container image)
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
