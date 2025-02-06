FROM phpdockerio/php:8.3-fpm

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        php8.3-amqp \
        php8.3-gd \
        php8.3-intl \
        php8.3-mcrypt \
        php8.3-mongodb \
        php8.3-mysql \
        php8.3-redis \
        php8.3-uuid \
        php8.3-xdebug \
        php8.3-bcmath \
        php8.3-yaml \
        php8.3-pgsql \
        php8.3-pdo \
        php8.3-pdo-pgsql \
        supervisor; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN mkdir -p "/etc/supervisor/logs"
COPY supervisord.conf /etc/supervisor/
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
