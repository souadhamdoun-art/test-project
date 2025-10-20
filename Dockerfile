FROM php:8.2-cli

ENV DEBIAN_FRONTEND=noninteractive

WORKDIR /var/www/html

# Install dependencies including SQLite
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    zip \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring zip exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Create SQLite database file
RUN touch database/database.sqlite

# Generate application key and run migrations
RUN php artisan key:generate && php artisan migrate --force

EXPOSE 8000
