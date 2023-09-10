# Base image
FROM php:8.1-fpm-alpine3.18

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apk --no-cache add \
    build-base \
    libzip-dev \
    zip \
    unzip \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    postgresql-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath gd

# Enable OPcache
RUN docker-php-ext-enable opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install application dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Check if .env file exists, if not copy .env.example
RUN if [ ! -f /var/www/html/.env ]; then cp /var/www/html/.env.example /var/www/html/.env; fi

# Generate Laravel application key
RUN php artisan key:generate

# Link storage directory
RUN php artisan storage:link

# Set up sqlite DB
RUN touch /var/www/html/database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/database
RUN chmod -R 775 /var/www/html/database


# Build front-end assets
RUN npm install
RUN npm run build

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
