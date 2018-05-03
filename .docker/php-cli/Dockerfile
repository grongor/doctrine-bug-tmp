FROM php:7.2-cli

# hack to make postgresql-client install work on stretch-slim
RUN mkdir -p /usr/share/man/man1 && \
    mkdir -p /usr/share/man/man7

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        dirmngr \
        gnupg \
        git \
        libpq-dev \
        postgresql-client \
#        ssh \
        unzip \
        && \
    docker-php-ext-install \
        pdo \
        pdo_pgsql

# grab gosu for easy step-down from root
ENV GOSU_VERSION 1.10
RUN set -x && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        wget && \
    rm -rf /var/lib/apt/lists/* && \
    wget -O /usr/local/bin/gosu \
        "https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-$(dpkg --print-architecture)" && \
    wget -O /usr/local/bin/gosu.asc \
        "https://github.com/tianon/gosu/releases/download/${GOSU_VERSION}/gosu-$(dpkg --print-architecture).asc" && \
    export GNUPGHOME="$(mktemp -d)" && \
    gpg --keyserver keyserver.ubuntu.com --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 && \
    gpg --batch --verify /usr/local/bin/gosu.asc /usr/local/bin/gosu && \
    rm -r "$GNUPGHOME" /usr/local/bin/gosu.asc && \
    chmod +x /usr/local/bin/gosu && \
    gosu nobody true

ENV TZ=UTC
RUN echo $TZ > /etc/timezone

RUN curl -sS https://getcomposer.org/installer | php -- --filename composer --install-dir /usr/local/bin

ADD php.ini /usr/local/etc/php

WORKDIR /app

COPY entrypoint /usr/local/bin/custom-entrypoint

ENTRYPOINT ["custom-entrypoint"]
CMD ["php"]
