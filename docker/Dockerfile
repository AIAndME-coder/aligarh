FROM php:7.4-apache


# Install dependencies
RUN apt-get update && \
    apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zip \
        unzip \
        curl \
        libzip-dev && \
    docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql gd zip && \
    a2enmod rewrite

# Add custom virtual host config
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer
