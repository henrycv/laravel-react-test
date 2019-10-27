##
## Name: laravel-test-pokeapi
## Author: https://about.me/henrycv
##

FROM php:7.3-fpm

# Root directory path
ARG APP_DIR=$APP_DIR
RUN pwd

# Set working directory
RUN mkdir -p $APP_DIR
WORKDIR $APP_DIR
RUN pwd

ENV DEBIAN_FRONTEND noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    --no-install-recommends apt-utils \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install extensions
RUN docker-php-ext-configure zip --with-libzip 
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli 

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Change current user to root
USER root

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www


RUN echo "" >> ~/.bashrc && \
    echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.bashrc
RUN export PATH="$HOME/.composer/vendor/bin:$PATH"

# Change current user to www
USER www

# Install Laravel tool
RUN composer global require laravel/installer

# Copy existing application directory contents
COPY . $APP_DIR

# Copy existing application directory permissions
COPY --chown=www:www . $APP_DIR

# Install Node JS using Ubuntu
# https://github.com/nodesource/distributions/blob/master/README.md#debinstall
USER root
RUN curl -sL https://deb.nodesource.com/setup_13.x | bash -
RUN apt-get install -y nodejs


# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]