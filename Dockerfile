FROM wordpress:6.7-php8.2-apache

RUN apt-get update && \
    apt-get install -y mariadb-server supervisor && \
    rm -rf /var/lib/apt/lists/*

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

COPY ashade/ /usr/src/wordpress/wp-content/themes/ashade/
COPY ashade-child/ /usr/src/wordpress/wp-content/themes/ashade-child/
RUN chown -R www-data:www-data /usr/src/wordpress/wp-content/themes/ashade \
    /usr/src/wordpress/wp-content/themes/ashade-child

ENV WORDPRESS_DB_HOST=127.0.0.1
ENV WORDPRESS_DB_USER=wordpress
ENV WORDPRESS_DB_PASSWORD=wordpress
ENV WORDPRESS_DB_NAME=wordpress

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
