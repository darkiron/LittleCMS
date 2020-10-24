FROM php:8.0.0RC2-fpm

RUN echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=${PHP_TIMEZONE:-UTC}" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

RUN apt-get update && apt-get install -y apt-utils zip git openssh-client libzip-dev zlib1g-dev libicu-dev g++  libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libxpm-dev \
    libvpx-dev \
    libwebp-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure gd

RUN docker-php-ext-install gd

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 2.0.1

RUN set -eux; \
  curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://raw.githubusercontent.com/composer/getcomposer.org/cb19f2aa3aeaa2006c0cd69a7ef011eb31463067/web/installer; \
  php -r " \
    \$signature = '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5'; \
    \$hash = hash('sha384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
      unlink('/tmp/installer.php'); \
      echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
      exit(1); \
    }"; \
  php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION}; \
  composer --ansi --version --no-interaction; \
  rm -f /tmp/installer.php; \
  find /tmp -type d -exec chmod -v 1777 {} +

ADD . /app
WORKDIR /app