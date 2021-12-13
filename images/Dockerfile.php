FROM php:7.4-fpm

MAINTAINER Nick Chaykovsky <lis@chaikovskie.com>

ENV TZ=UTC
ARG DEBIAN_FRONTEND noninteractive

# Setup correct timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
    apt-get install -y \
        curl \
        wget \
        git \
        libgmp-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
    
    && docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \

    # ctype, curl, json, dom, iconv, simplexml, tokenizer, libxml is already here
    && docker-php-ext-install -j$(nproc) \
        gd \
        mysqli \
        gmp \
    
    # install composer just in case
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./config/php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www
EXPOSE 9000
CMD ["php-fpm"]