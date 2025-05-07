# syntax=docker/dockerfile:1

FROM php:8.2-apache

# 1) Install PDO MySQL (and any other PHP extensions you need)
RUN docker-php-ext-install pdo pdo_mysql

# 2) Enable mod_rewrite (optional but common)
RUN a2enmod rewrite

# 3) Copy your entire app into Apache’s document root
COPY . /var/www/html/

# 4) Instruct Apache to listen on the PORT Render sets
ARG PORT       # this will get passed in by Render at build time
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
 && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# 5) Expose that port
EXPOSE ${PORT}

# 6) Launch Apache in the foreground
CMD ["apache2-foreground"]
