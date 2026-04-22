FROM composer/composer:2-bin AS composer

FROM dunglas/frankenphp:1-php8.4-trixie AS base

RUN apt update && apt -y install \
    git \
    unzip

RUN install-php-extensions \
    gd \
    intl \
    mbstring \
    opcache \
    pdo_mysql \
    xml \
    zip

ENV LC_ALL=C.UTF-8

WORKDIR /app

COPY docker/Caddyfile /etc/frankenphp/Caddyfile

#
# Development
#

FROM base AS dev

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USER_NAME=appuser
ARG GROUP_NAME=appuser

COPY --from=composer /composer /usr/bin/composer

RUN git config --system --add safe.directory /app

# Based on https://frankenphp.dev/docs/docker/#running-as-a-non-root-user
RUN \
    groupadd --gid ${GROUP_ID} ${GROUP_NAME}; \
    useradd --gid ${GROUP_ID} --uid ${USER_ID} ${USER_NAME}; \
    # Add additional capability to bind to port 80 and 443
    setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp; \
    # Give write access to /data/caddy and /config/caddy
    chown -R ${USER_NAME}:${GROUP_NAME} /data/caddy && chown -R ${USER_NAME}:${GROUP_NAME} /config/caddy
USER ${USER_NAME}

#
# Production
#

FROM base AS prod-builder

COPY --from=composer /composer /usr/bin/composer
COPY . /app

RUN --mount=type=cache,target=/tmp/composer-cache \
    composer install --no-dev --no-progress --no-interaction --optimize-autoloader --classmap-authoritative \
    && php ./init --env=Production --overwrite=All \
    && chmod +x yii \
    && mkdir -p runtime/rbac www/assets

FROM base AS prod

ENV APP_ENV=prod

RUN mkdir -p /data/caddy/locks /config/caddy && chown -R www-data:www-data /data/caddy /config/caddy

COPY --from=prod-builder --chown=www-data:www-data /app /app
USER www-data
