FROM registry.cn-hangzhou.aliyuncs.com/wuxyyin/docker-php-nginx:fpm-7.3

# COPY new nginx config
COPY docker/nginx/conf.d/ /etc/nginx/conf.d/

# COPY entrypoint to image
COPY docker/entrypoint.sh /

# add exec
RUN chown -R nginx.nginx /app && \
    chmod -R 755 /app && \
    chmod -R 777 /app/config /app/logs /app/ext /app/ext_custom && \
    chmod +x /entrypoint.sh

# Make the document root a volume
#VOLUME /app

# Switch to use a non-root user from here on
#USER nginx

# Add application
#WORKDIR /app

# Expose the port nginx is reachable on
#EXPOSE 80

# Let supervisord start nginx & php-fpm
#CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
ENTRYPOINT ["/entrypoint.sh"]

# Configure a healthcheck to validate that everything is up&running
#HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8081/fpm-ping
