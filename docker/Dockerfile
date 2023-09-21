ARG php_version
FROM php:${php_version}-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

WORKDIR /srv/current/

RUN apt-get update -y && apt-get install -y openssl libzip-dev zip unzip git libonig-dev libpq-dev mc vim htop supervisor
RUN docker-php-ext-install pdo pdo_mysql mbstring zip pgsql pdo_pgsql \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    usermod -s /bin/bash $user

# add www-data user to current user group
RUN usermod www-data -a -G $user

COPY . /srv/current/

USER $user

EXPOSE 9000
CMD ["php-fpm"]