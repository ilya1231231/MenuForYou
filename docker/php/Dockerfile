FROM php:8.3-fpm

WORKDIR /var/www/html/parser

RUN apt-get update && apt-get install -y \
    libzip-dev\
    curl \
    zip \
    unzip\
    && docker-php-ext-install sockets zip
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#изучить как запускать контейнеры под пользователем
RUN addgroup --system --gid 1000 user \
    && adduser --system --uid 1000 --ingroup user user

CMD ["php-fpm"]