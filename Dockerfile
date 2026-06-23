FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libicu-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-install intl mysqli pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/start-ci.sh /usr/local/bin/start-ci.sh

RUN chmod +x /usr/local/bin/start-ci.sh

WORKDIR /var/www/html

CMD ["/usr/local/bin/start-ci.sh"]
