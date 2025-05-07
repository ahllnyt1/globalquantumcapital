# 1) base PHP + Apache image
FROM php:8.2-apache

# 2) install PDO MySQL
RUN apt-get update \
 && docker-php-ext-install pdo pdo_mysql \
 && a2enmod rewrite

# 3) set working dir and copy your app
WORKDIR /var/www/html
COPY . /var/www/html

# 4) fix permissions (Apache runs as www‑data)
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html

# 5) expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]
