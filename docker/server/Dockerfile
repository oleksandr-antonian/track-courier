FROM php:8.3.4-fpm-bookworm

# install necessary utilities & php libs
# libonig-dev as a replacement for php-mbstring (ref: https://stackoverflow.com/questions/59251008/docker-laravel-configure-error-package-requirements-oniguruma-were-not-m)
# zip needed for running composer inside container
# sockets needed for amqplib
RUN apt-get update -y && apt-get install -y \
    libxml2-dev \
    libonig-dev \
    libpng-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    zip \
    git \
    unzip \
	ca-certificates \
	curl \
	gnupg \
    && docker-php-ext-install mysqli gd pdo pdo_mysql bcmath zip intl pcntl soap curl sockets

# For installing node 20, Download and import the Nodesource GPG key
RUN mkdir -p /etc/apt/keyrings
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg

# For installing node 20, Create deb repository
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list

# Finally, install node
RUN apt-get update -y  && apt-get install -y \
	nodejs

# install redis php extension
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY server.sh /var/www/html/docker/server/server.sh

RUN chmod +x /var/www/html/docker/server/server.sh

CMD ["/bin/sh", "-c", "/var/www/html/docker/server/server.sh"]