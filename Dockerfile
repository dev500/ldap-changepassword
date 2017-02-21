FROM php:7.1-cli
RUN apt-get update \
    && apt-get install libldap2-dev -y \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap
COPY ./src /usr/src
ADD ./entrypoint.sh /entrypoint.sh
RUN chmod 755 /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
WORKDIR /usr/src
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
