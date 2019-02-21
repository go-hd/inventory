FROM php:7.2

MAINTAINER "Yuto Kawamoto" <y.kawamoto@go-hd.jp>

WORKDIR /tmp

RUN apt-get update -y
RUN apt-get install -y git unzip
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer self-update
RUN composer global require hirak/prestissimo

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN mkdir -p /data
VOLUME ["/data"]
WORKDIR /data

ENTRYPOINT ["composer"]
CMD ["--help"]
