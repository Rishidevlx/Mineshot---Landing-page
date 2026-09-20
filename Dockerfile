FROM php:8.2-apache

# Install PDO MySQL extension for TiDB/MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy all files into Apache document root
COPY . /var/www/html/

# Fix Apache to listen on Render's dynamic PORT environment variable
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

EXPOSE 80

CMD ["apache2-foreground"]
