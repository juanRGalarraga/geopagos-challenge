# Imagen base de PHP con Apache
FROM php:8.2-apache

# Copy composer.lock and composer.json
COPY ./composer.lock ./composer.json /var/www/html/

# Configurar el directorio de trabajo
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

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy existing application directory permissions
COPY --chown=${APP_USER}:${APP_USER} ./ /var/www/html

# Habilitar mod_rewrite para Laravel y configurar el DocumentRoot de Apache
RUN a2enmod rewrite \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copiar archivos del proyecto
COPY . .

RUN cp .env.example .env

# Exponer el puerto 80
EXPOSE 80

RUN bash -c "composer install --no-dev --no-interaction --prefer-dist";

RUN php artisan key:generate

# Comando por defecto al iniciar el contenedor
CMD ["apache2-foreground"]
