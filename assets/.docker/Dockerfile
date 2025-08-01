FROM php:8-fpm

LABEL maintainer="Sam Maosa <maosa.sam@gmail.com>"

WORKDIR /app
# Install system packages
RUN apt-get update && \
    apt-get install -y \
        build-essential \
        locales \
        git \
        curl \
        nano \
        g++ \
        supervisor \
        libfreetype6-dev \
    	libjpeg62-turbo-dev \
    	libpng-dev \
        zip \
        jpegoptim \
        optipng \
        pngquant \
        gifsicle \
        unzip \
        git \
        curl \
        lua-zlib-dev \
        libmemcached-dev \
        ldap-utils \
        postgresql \
        libldb-dev libldap2-dev

RUN apt-get install -y libzip-dev libxml2-dev

# Install PHP extensions \
RUN docker-php-ext-configure ldap \
      && docker-php-ext-configure gd --with-freetype --with-jpeg \
      && docker-php-ext-install -j$(nproc) gd \
      && docker-php-ext-install ldap opcache pdo_mysql sockets zip xml

RUN apt-get install -y zlib1g-dev libssl-dev

# Install PECL extensions
RUN pecl install memcached && docker-php-ext-enable memcached

RUN pecl install redis
RUN docker-php-ext-enable redis

RUN docker-php-ext-configure tokenizer --with-libdir=lib/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y sudo

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install exif intl pcntl
RUN apt-get update && apt-get install -y wkhtmltopdf
RUN apt-get install -y libmagickwand-dev

RUN curl -sL https://deb.nodesource.com/setup_24.x | bash -
RUN apt-get install -y nodejs ghostscript
RUN pecl install pcov && docker-php-ext-enable pcov
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY .docker/config /tmp/config
# Download trusted certs
RUN mkdir -p /etc/ssl/certs && update-ca-certificates && \
# Copy php configuration
    cp /tmp/config/php.ini /usr/local/etc/php/php.ini && \
# Copy supervisor config
    mkdir /etc/supervisor.d && \
    cp /tmp/config/supervisord.conf /etc/supervisord.conf && \
    cp -r /tmp/config/supervisor.d /etc && \
# Copy cron job \
    cp /tmp/config/crontab /etc/cron.d/www-data && \
    cp /tmp/config/entrypoint.sh /entrypoint.sh && \
    rm -rf /tmp/config && \
    chmod a+x /entrypoint.sh

ENV ENABLE_CRON_JOB=${ENABLE_CRON_JOB:-false}
ENV ENABLE_LARAVEL_WORKER=${ENABLE_LARAVEL_WORKER:-false}
ENV ENABLE_LARAVEL_HORIZON=${ENABLE_LARAVEL_HORIZON:-false}
ENV ENABLE_LARAVEL_WEBSOCKETS=${ENABLE_LARAVEL_WEBSOCKETS:-false}
ARG UID=1000
ARG USER='dev'

#Create non-root sudoer
RUN groupadd  $USER && \
    useradd --create-home --no-log-init --uid $UID --gid $USER $USER && \
    echo "$USER ALL=(ALL:ALL) NOPASSWD:ALL" | tee -a /etc/sudoers && \
    usermod -aG www-data $USER

RUN mkdir -p /home/$USER/.composer && chown -R $USER:www-data /home/$USER && chown -R $USER:www-data /app

RUN echo "* * * * * www-data php /app/artisan schedule:run >> /app/storage/logs/cron.log 2>&1" >> /etc/crontab

ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm", "-F"]
