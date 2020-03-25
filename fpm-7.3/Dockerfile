FROM alpine:3.10
LABEL Maintainer="Sean Wu <wuxyyin@qq.com>" \
      Description="Lightweight container with Nginx 1.16 & PHP-FPM 7.3 based on Alpine Linux."

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session \
    php7-mbstring php7-gd php7-opcache php7-pdo php7-pdo_mysql php7-bcmath php7-simplexml \
    php7-zip php7-iconv php7-redis php7-ftp \
    nginx supervisor curl vim

# Configure nginx
COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/nginx/conf.d/ /etc/nginx/conf.d/

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY config/php.ini /etc/php7/conf.d/custom.ini

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/supervisord.conf
COPY config/supervisor/conf.d/ /etc/supervisor/conf.d/

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nginx.nginx /run && \
  chown -R nginx.nginx /var/lib/nginx && \
  chown -R nginx.nginx /var/tmp/nginx && \
  chown -R nginx.nginx /var/log/nginx

# Setup document root
RUN mkdir -p /app

#COPY --chown=nobody src/ /var/www/html/
COPY src/ /app/

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nginx.nginx /app

# Make the document root a volume
VOLUME /app

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
