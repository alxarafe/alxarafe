FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpq-dev \
    git \
 && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto FPM
EXPOSE 9000
