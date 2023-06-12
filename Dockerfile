# Use the official PHP image as the base image
FROM php:8.1-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the composer.json and composer.lock files to the container
COPY composer.json composer.lock ./

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies using Composer
RUN composer install --no-scripts --no-autoloader

# Copy the application code to the container
COPY . .

# Generate the autoloader
RUN composer dump-autoload

# Set the ownership permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 8000 to the host
EXPOSE 8000

# Run the PHP development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

