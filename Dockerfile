FROM php:7.4-cli-alpine3.15
RUN mkdir -p /src/app
COPY . /src/app
WORKDIR /src/app
RUN php migrate.php
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 3000
ENTRYPOINT ["php", "/src/app/public/index.php"]
