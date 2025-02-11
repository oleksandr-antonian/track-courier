FROM php:8.3.4-cli-bookworm

# install necessary utilities & php libs
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
	&& docker-php-ext-install pdo pdo_mysql mysqli gd calendar mbstring bcmath intl curl fileinfo iconv

RUN pecl install -o -f redis \
	&& rm -rf /tmp/pear \
	&& docker-php-ext-enable redis

COPY start.sh /root/start.sh
RUN dos2unix /root/start.sh && chmod +x /root/start.sh

ENTRYPOINT ["/root/start.sh"]
