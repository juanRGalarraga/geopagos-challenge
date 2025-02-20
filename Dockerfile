
FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl


RUN apt-get clean && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install pdo_mysql


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy existing application directory permissions
COPY --chown=${APP_USER}:${APP_USER} ./ /var/www/html

# Habilitar mod_rewrite para Laravel y establece la carpeta "public" como el directorio raíz de index.php
RUN a2enmod rewrite \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

COPY . .

RUN cp .env.example .env

EXPOSE 80

# Copy composer.lock and composer.json
COPY ./composer.lock ./composer.json /var/www/html/

RUN bash -c "composer install --no-dev --no-interaction --prefer-dist" \
&& php artisan key:generate

# Run apache in foreground
CMD ["apache2-foreground"]
