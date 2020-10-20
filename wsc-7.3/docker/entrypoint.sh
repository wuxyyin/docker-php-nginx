#!/bin/sh

chown -R nginx.nginx /app

/usr/bin/supervisord -c /etc/supervisor/supervisord.conf