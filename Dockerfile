FROM php:8.2-fpm

#ARG user
#ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    build-essential

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql sockets mbstring exif pcntl bcmath gd zip

# Custom php.ini
ADD ./docker-compose/php/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Set working directory
WORKDIR /var/www

# Add user for Laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www
