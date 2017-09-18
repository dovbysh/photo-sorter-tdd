FROM php:7.0-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
		curl git subversion openssl mercurial bash \
		zlib1g-dev \
		openssh-client \
        libimage-exiftool-perl \
        mediainfo \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
	 && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 1.5.2

RUN curl -s -f -L -o /tmp/installer.php https://raw.githubusercontent.com/composer/getcomposer.org/da290238de6d63faace0343efbdd5aa9354332c5/web/installer \
 && php -r " \
    \$signature = '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410'; \
    \$hash = hash('SHA384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
        unlink('/tmp/installer.php'); \
        echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
        exit(1); \
    }" \
 && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} \
 && composer --ansi --version --no-interaction \
 && rm -rf /tmp/* /tmp/.htaccess

RUN curl -s -f -L -o /usr/bin/phar-composer https://github.com/clue/phar-composer/releases/download/v1.0.0/phar-composer.phar \
    && chmod +x /usr/bin/phar-composer

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/  \
    && docker-php-ext-install gd exif

