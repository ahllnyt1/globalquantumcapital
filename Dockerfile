# Use the official PHP+Apache image
FROM php:8.2-apache

# Install PDO MySQL extension (and any others you need)
RUN docker-php-ext-install pdo pdo_mysql

# Copy your code into Apache’s document root
COPY . /var/www/html

# Make sure the BASE_URL in config.php matches the Render URL you'll get later
# e.g. define('BASE_URL','https://globalquantumcapital.onrender.com');

# Expose HTTP
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
