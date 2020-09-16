FROM alpine:3.10
LABEL Maintainer="Sean Wu <wuxyyin@qq.com>" \
      Description="Lightweight container with Nginx 1.16 & PHP-FPM 7.3 based on Alpine Linux."

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-xmlwriter php7-ctype php7-session \
    php7-mbstring php7-gd php7-opcache php7-pcntl php7-tokenizer php7-pdo php7-pdo_mysql php7-bcmath php7-simplexml \
    php7-posix php7-zip php7-iconv php7-ftp php7-apcu \
    nginx supervisor curl vim

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

# Install swoole
RUN apk --no-cache add php-pear php7-dev gcc g++ make git librdkafka librdkafka-dev && \
    pecl channel-update pecl.php.net && \
#    pecl install swoole && \
#    pecl install redis && \
#    pecl install rdkafka && \
    rm -rf /tmp/pear && \
    apk del php-pear php7-dev gcc g++ make git

# Configure nginx
COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/nginx/conf.d/ /etc/nginx/conf.d/

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY config/php/conf.d/ /etc/php7/conf.d/

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/supervisord.conf
COPY config/supervisor/conf.d/ /etc/supervisor/conf.d/

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nginx.nginx /run && \
  chown -R nginx.nginx /var/lib/nginx && \
  chown -R nginx.nginx /var/tmp/nginx && \
  chown -R nginx.nginx /var/log/nginx

# Setup document nginx
RUN mkdir -p /app

#COPY --chown=nobody src/ /app/
COPY src/ /app/

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nginx.nginx /app

# Make the document root a volume
# VOLUME /app

# Switch to use a non-root user from here on
#USER nginx

# Add application
WORKDIR /app

# Expose the port nginx is reachable on
EXPOSE 80

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
#HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
