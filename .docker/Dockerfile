ARG BASE_IMAGE=local:runtime-v1.0

FROM ${BASE_IMAGE}

ARG APP_ENV=production

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0

WORKDIR /var/www/project/public

# Change env variable
RUN awk "{gsub(/_ENV development;/,\"_ENV ${APP_ENV};\")}1" /etc/nginx/nginx.conf > nginx.conf \
    && mv nginx.conf /etc/nginx/nginx.conf

COPY . /var/www/project/public

RUN mkdir -p uploads \
    && chmod -R 777 uploads

# RUN composer install --no-dev && composer clear-cache

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
