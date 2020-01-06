# Docker PHP-FPM 7.3 & Nginx 1.16 on Alpine Linux
Example PHP-FPM 7.3 & Nginx 1.16 setup for Docker, build on [Alpine Linux](http://www.alpinelinux.org/).
The image is only +/- 35MB large.

Repository: https://github.com/wuxyyin/docker-php-nginx


* Built on the lightweight and secure Alpine Linux distribution
* Very small Docker image size (+/-35MB)
* Uses PHP 7.3 for better performance, lower cpu usage & memory footprint
* Optimized for 100 concurrent users
* Optimized to only use resources when there's traffic (by using PHP-FPM's ondemand PM)
* The servers Nginx, PHP-FPM and supervisord run under a non-privileged user (nobody) to make it more secure
* The logs of all the services are redirected to the output of the Docker container (visible with `docker logs -f <container name>`)
* Follows the KISS principle (Keep It Simple, Stupid) to make it easy to understand and adjust the image to your needs


[![Docker Pulls](https://img.shields.io/docker/pulls/wuxyyin/docker-php-nginx.svg)](https://hub.docker.com/r/wuxyyin/docker-php-nginx/)
[![Docker image layers](https://images.microbadger.com/badges/image/wuxyyin/docker-php-nginx.svg)](https://microbadger.com/images/wuxyyin/docker-php-nginx)

### Breaking changes (26/01/2019)

Please note that the new builds since 26/01/2019 are exposing a different port to access Nginx.
To be able to run Nginx as a non-privileged user, the port it's running on needed
to change to a non-privileged port (above 1024).

## Usage

Start the Docker container:

    docker run -p 80:8080 wuxyyin/docker-php-nginx:tagname

See the PHP info on http://localhost, or the static html page on http://localhost/test.html

Or mount your own code to be served by PHP-FPM & Nginx

    docker run -p 80:8080 -v ~/my-codebase:/app wuxyyin/docker-php-nginx:tagname

## Configuration
In [config/](config/) you'll find the default configuration files for Nginx, PHP and PHP-FPM.
If you want to extend or customize that you can do so by mounting a configuration file in the correct folder;

Nginx configuration:

    docker run -v "`pwd`/nginx-server.conf:/etc/nginx/conf.d/server.conf" wuxyyin/docker-php-nginx:tagname

PHP configuration:

    docker run -v "`pwd`/php-setting.ini:/etc/php7/conf.d/settings.ini" wuxyyin/docker-php-nginx:tagname

PHP-FPM configuration:

    docker run -v "`pwd`/php-fpm-settings.conf:/etc/php7/php-fpm.d/server.conf" wuxyyin/docker-php-nginx:tagname

_Note; Because `-v` requires an absolute path I've added `pwd` in the example to return the absolute path to the current directory_ 
