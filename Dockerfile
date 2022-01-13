FROM php:7.4.1-cli-alpine3.11
RUN mkdir -p /src/app
COPY . /src/app
WORKDIR /src/app
RUN php migrate.php
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 3000
ENTRYPOINT ["php", "/src/app/public/index.php"]
