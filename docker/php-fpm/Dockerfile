FROM php:7.2-fpm

# Install Dependences
RUN apt-get update \
    && apt-get upgrade -yq \
    && apt-get install -yq apt-utils \
    libpq-dev libmcrypt-dev libreadline-dev libxslt-dev libxml2-dev libicu-dev zlib1g-dev libmemcached-dev curl \
    librabbitmq4 librabbitmq-dev \
    libssl-dev \
    git \
    libtidy-dev libtidy5deb1 libbz2-dev libfontconfig \
    p7zip-full \
    telnet nano iputils-ping mc vim htop \
    traceroute

# Install PHP
RUN apt-get update \
    && docker-php-ext-install bz2 \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gettext \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install json \
    && docker-php-ext-install xmlrpc \
    && docker-php-ext-install xsl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-ext-install tidy \
    && pecl channel-update pecl.php.net \
    && pecl install redis \
    && pecl install xdebug-2.6.1 \
    && pecl install mcrypt-1.0.1 \
    && pecl install rar \
    && pecl install timezonedb \
    && docker-php-ext-enable redis xdebug  mcrypt  rar timezonedb


# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --1 --install-dir=/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# node/nodejs and npm
RUN curl -sL https://deb.nodesource.com/setup_8.x -o nodesource_setup.sh \
    && rm -rf /var/lib/apt/lists/* \
    && bash nodesource_setup.sh \
    && apt-get install -y nodejs npm \
    && rm nodesource_setup.sh \
    && npm install -g pm2@latest \
    && pm2 install pm2-logrotate


COPY config/ /

COPY entrypoint.sh /entrypoint.sh

ENTRYPOINT /bin/bash -c "/bin/bash /entrypoint.sh"
