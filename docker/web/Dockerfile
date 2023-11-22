FROM php:8.1-apache

# Set variables
ARG USER_NAME="vscode"
ARG USER_GROUP_NAME="php"
ARG USER_UID="1000"
ARG USER_GID="1000"
ARG PKG="sudo curl git wget zip unzip vim libfreetype6-dev libjpeg62-turbo-dev libpng-dev libpq-dev libonig-dev libxml2-dev libzip-dev"
ARG PHP_PKG="mbstring exif pcntl bcmath gd pdo pdo_mysql mysqli"
ARG PECL_PKG="xdebug"
ARG ENVIRONMENT

# Set timezone
ENV TZ=Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone

# Copy files
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Update system and install packages
RUN apt-get update && \
    apt-get install -y --no-install-recommends ${PKG} && \
    docker-php-ext-install ${PHP_PKG} && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Install pecl packages
RUN pecl install ${PECL_PKG} && \
    docker-php-ext-enable ${PECL_PKG} && \
    rm -r /tmp/pear

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Activate mod_rewrite
RUN a2enmod rewrite

# Create user and group
RUN groupadd --gid ${USER_GID} ${USER_GROUP_NAME} && \
    useradd --uid ${USER_UID} --gid ${USER_GROUP_NAME} --shell /bin/bash -m ${USER_NAME} && \
    usermod -aG www-data ${USER_NAME}

# Add sudo group
RUN echo "%${USER_GROUP_NAME} ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/${USER_GROUP_NAME} && \
    chmod 0440 /etc/sudoers.d/${USER_GROUP_NAME}

# Switch to the user
USER ${USER_NAME}