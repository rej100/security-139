FROM php:8.1-apache

# Install mysqli extension for MySQL support
RUN docker-php-ext-install mysqli

# Copy the website files into the Apache document root
COPY php/ /var/www/html/

# Create a secure directory and copy the secret files from the repository root
RUN mkdir -p /var/secret
COPY secret_files/ /var/secret/