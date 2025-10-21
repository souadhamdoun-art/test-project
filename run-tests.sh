#!/bin/bash

# Pest test runner using Docker
echo "🧪 Running Pest tests in Docker container..."

docker run --rm \
    -v $(pwd):/app \
    -w /app \
    php:8.2-cli-alpine \
    sh -c "
        apk add --no-cache libzip-dev zip && \
        docker-php-ext-install zip && \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
        composer install && \
        php pest-runner.php
    "
