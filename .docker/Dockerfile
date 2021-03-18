FROM composer:2.0.11 AS composer
FROM php:7.4.14-fpm-buster
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update -qq && apt-get install -y \
  git \
  curl \
  g++ \
  sudo \
  build-essential \
  mariadb-client \
  iputils-ping \
  libcurl3-dev \
  libzip-dev \
  libjpeg-dev \
  libpq-dev \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  libxrender1 \
  libfontconfig1 \
  libx11-dev \
  libjpeg62 \
  libxtst6 \
  libfreetype6-dev \
  libsqlite3-dev \
  libldap2-dev \
  libssl-dev \
  zip \
  unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
&& docker-php-ext-install pdo_mysql \
    tokenizer \
    fileinfo \
    ctype \
    mbstring \
    exif \
    intl \
    pcntl \
    bcmath \
    gd \
    json \
    curl \
    xml \
    zip \
    ldap \
    pdo_sqlite \
&& pecl install redis && docker-php-ext-enable redis \
&& pecl install xdebug && docker-php-ext-enable xdebug \
&& apt-get clean && rm -rf /var/lib/apt/lists/*

COPY .docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY .docker/local.ini /usr/local/etc/php/conf.d/zzz_app.ini

ARG user
ARG uid
RUN useradd -G www-data,root -u $uid -d /home/$user $user && echo "$user:$user" | chpasswd && adduser $user sudo
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
WORKDIR /var/www
USER $user
CMD ["php-fpm"]
