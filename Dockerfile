# Use Ubuntu as the base image
FROM ubuntu:latest

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive

# Set environment variable to allow Composer plugins to run as super user
ENV COMPOSER_ALLOW_SUPERUSER 1

# Update and install dependencies
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y php8.1-fpm 
RUN apt-get install -y php8.1-common 
RUN apt-get install -y php-mbstring
RUN apt-get install -y php-xml 
RUN apt-get install -y php8.1-zip 
RUN apt-get install -y php8.1-curl
RUN apt-get install -y php8.1-sqlite3
RUN apt-get install -y nginx
RUN apt-get install -y curl

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a working directory
WORKDIR /var/www/html

# Copy your Laravel app files to the working directory
COPY . .

# Create the SQLite database file
RUN touch database/database.sqlite
RUN chmod 777 database/database.sqlite


# Install Laravel dependencies
RUN composer install --no-scripts --no-autoloader

# Generate autoload files
RUN composer dump-autoload

# Adjust permissions for storage directory and log files
RUN chown -R www-data:www-data storage

# Copy Nginx configuration
COPY nginx/default.conf /etc/nginx/sites-available/default


# Run Laravel migrations
RUN php artisan migrate

# Seed the database
RUN php artisan db:seed --class=CategorySeeder
RUN php artisan db:seed --class=SourceSeeder


RUN php artisan app:scrape-news

# Expose port 80
EXPOSE 8080

# Start PHP-FPM and Nginx
CMD service php8.1-fpm start && nginx -g "daemon off;"
