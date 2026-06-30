FROM php:8.1-cli

WORKDIR /app

# Install deps
RUN apt-get update && apt-get install -y \
    unzip \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy app
COPY . .

# Install composer deps
RUN composer install --no-dev --optimize-autoloader

# Create SQLite database
RUN touch database/database.sqlite
RUN php artisan migrate --force

# Seed users
RUN echo "<?php
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
if (!\App\Models\User::where('email','admin@pickup.com')->exists()) {
    \App\Models\User::create(['name'=>'Admin Pickup','email'=>'admin@pickup.com','password'=>bcrypt('admin123'),'role'=>'admin']);
    \App\Models\User::create(['name'=>'Kurir Satu','email'=>'kurir@pickup.com','password'=>bcrypt('kurir123'),'role'=>'kurir']);
}" | php

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
