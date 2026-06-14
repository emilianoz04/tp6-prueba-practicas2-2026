FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install gd zip

# Activar mod_rewrite
RUN a2enmod rewrite

# Instalar Composer (igual que el profe)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Crear carpetas necesarias
RUN mkdir -p /var/www/html/pdf \
    && touch /var/www/html/datos.txt \
    && chown -R www-data:www-data /var/www/html
