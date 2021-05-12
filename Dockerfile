# docker/php-fpm/Dockerfile

FROM php:fpm
COPY docker/php-fpm/wait-for-it.sh /usr/bin/wait-for-it
RUN apt-get update
RUN chmod +x /usr/bin/wait-for-it
RUN apt-get install -y \
            zip
RUN docker-php-ext-install pdo_mysql sockets
COPY ./app /var/www
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install ; wait-for-it database:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm
EXPOSE 9000
