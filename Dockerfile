# Use the official PHP 7.4 CLI image as the base image
FROM php:8.3-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip bcmath \
    && apt-get clean

# Set environment variable for Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /app
WORKDIR /app

# Install PHP dependencies using Composer
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# Optional: Optimize Composer autoloader
RUN composer dump-autoload --optimize
