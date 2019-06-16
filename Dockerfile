FROM php:7.3.6-cli-alpine3.8

RUN apk update && apk upgrade \
    && apk add --no-cache $PHPIZE_DEPS python ffmpeg sox \
    && rm -rf /var/cache/apk/* \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install opcache

ENV APP_HOME /var/www/html/youtube-channel-downloder

WORKDIR $APP_HOME

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# youtube-dl
RUN curl -L https://yt-dl.org/downloads/latest/youtube-dl -o /usr/local/bin/youtube-dl \
  && chmod a+rx /usr/local/bin/youtube-dl

COPY . ./

# composer
RUN composer install

# php
COPY ./docker/php/conf/php.ini /usr/local/etc/php/php.ini

CMD ["/bin/sh", "./entrypoint.sh"]