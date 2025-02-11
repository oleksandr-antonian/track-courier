FROM php:8.3.4-cli-bookworm

# install necessary utilities & php libs
# libonig-dev as a replacement for php-mbstring (ref: https://stackoverflow.com/questions/59251008/docker-laravel-configure-error-package-requirements-oniguruma-were-not-m)
# docker-php-ext-install pcntl - required for laravel horizon

RUN apt-get update -y && apt-get install -y \
	libxml2-dev \
	libonig-dev \
	libpng-dev \
	libzip-dev \
	libcurl4-openssl-dev \
	supervisor \
	curl \
	zip \
	git \
	unzip \
	&& docker-php-ext-install mysqli gd pdo pdo_mysql bcmath zip intl pcntl

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# copy supervisord files
COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY horizon.conf /etc/supervisor/conf.d/horizon.conf

# start supervisord
CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf" ]
