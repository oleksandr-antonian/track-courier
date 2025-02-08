FROM php:8.3.4-cli-bookworm

# install necessary utilities & php libs
# libonig-dev as a replacement for php-mbstring (ref: https://stackoverflow.com/questions/59251008/docker-laravel-configure-error-package-requirements-oniguruma-were-not-m)
# zip needed for running composer inside container

RUN apt-get update -y && apt-get install -y \
	libxml2-dev \
	libonig-dev \
	libpng-dev \
	libzip-dev \
	libcurl4-openssl-dev \
	zip \
	cron \
	git \
	unzip \
	dos2unix \
	&& docker-php-ext-install mysqli gd calendar mbstring bcmath intl curl fileinfo iconv

RUN pecl install -o -f redis \
	&&  rm -rf /tmp/pear \
	&&  docker-php-ext-enable redis 

COPY start.sh /root/start.sh
RUN dos2unix /root/start.sh && chmod +x /root/start.sh

ENTRYPOINT ["/root/start.sh"]
