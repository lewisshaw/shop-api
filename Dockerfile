FROM php:7.0-apache
ADD . /var/www/html
RUN a2enmod rewrite
EXPOSE 80
