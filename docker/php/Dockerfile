FROM php:8.3-fpm

WORKDIR /var/www/html/app

RUN apt-get update && apt-get install -y \
    libzip-dev\
    curl \
    zip \
    unzip\
    && docker-php-ext-install sockets zip mysqli pdo_mysql
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#изучить как запускать контейнеры под пользователем
#RUN addgroup --system --gid ${USER_ID} ${USER} \
#    && adduser --system --uid ${USER_ID} --ingroup ${USER} ${USER}

CMD ["php-fpm"]