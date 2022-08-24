FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG NODE_VERSION=16

# Install system dependencies
RUN apt-get update  \
    && apt-get install -y \
    build-essential \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor git libzip-dev vim \
    gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libwebp-dev \
    libxpm-dev \
    libmcrypt-dev \
    libonig-dev

# configure, install and enable all php packages
RUN  docker-php-ext-configure gd --prefix=/usr --with-jpeg --with-webp --with-xpm --with-freetype

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl xml soap session mysqli


# Install Node.js
RUN curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Install cron
RUN apt-get install -y cron

# install Redis
RUN pecl install redis && docker-php-ext-enable redis

# Clear cache
RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# cria o diretório de logs para o Supervisor
RUN mkdir /var/log/webhook
RUN mkdir /var/log/nginx

COPY docker-server/start-container /usr/local/bin/start-container
COPY docker-server/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

#configurar o scheduler para rodar o cron
COPY docker-server/scheduler /etc/cron.d/scheduler
RUN chmod 0644 /etc/cron.d/scheduler \
    && crontab /etc/cron.d/scheduler

EXPOSE 80

ENTRYPOINT ["start-container"]
