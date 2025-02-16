FROM php:8.1-apache

# Install mysqli extension for MySQL support
RUN docker-php-ext-install mysqli

# Copy the website files into the Apache document root
COPY . /var/www/html/
