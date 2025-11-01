# 1. Use official PHP image with Apache server
FROM php:8.2-apache

# 2. Enable Apache rewrite (required for Laravel routes)
RUN a2enmod rewrite

# 3. Set working directory inside the container
WORKDIR /var/www/html

# 4. Copy all Laravel files into the container
COPY . .

# 5. Install system dependencies and Composer
RUN apt-get update && apt-get install -y unzip git && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# 7. Give permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Set Apache to use Laravel’s public directory as root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# 9. Expose the web port
EXPOSE 80

# 10. Start Apache server
CMD ["apache2-foreground"]
