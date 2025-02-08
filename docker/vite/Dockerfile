FROM node:20.10.0-bullseye

RUN apt-get update -y && apt-get install -y cron

WORKDIR /var/www/html/

COPY server.sh /var/www/html/docker/vite/server.sh

RUN chmod +x /var/www/html/docker/vite/server.sh

CMD ["/bin/sh", "-c", "/var/www/html/docker/vite/server.sh"]
