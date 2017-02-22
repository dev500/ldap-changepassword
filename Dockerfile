FROM php:7.1-cli
RUN apt-get update \
    && apt-get install libldap2-dev -y \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap
WORKDIR /usr/src
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
ADD ./entrypoint.sh /entrypoint.sh
RUN chmod 755 /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
COPY ./src /usr/src
