FROM wordpress:6.7-php8.2-apache

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

COPY mu-plugins/ /usr/src/wordpress/wp-content/mu-plugins/
COPY ashade/ /usr/src/wordpress/wp-content/themes/ashade/
COPY ashade-child/ /usr/src/wordpress/wp-content/themes/ashade-child/
RUN chown -R www-data:www-data /usr/src/wordpress/wp-content/themes/ashade \
    /usr/src/wordpress/wp-content/themes/ashade-child

# Set at runtime by Render (see render.yaml). Defaults for local docker-compose only.
ENV WORDPRESS_DB_HOST=mysql:3306
ENV WORDPRESS_DB_USER=wordpress
ENV WORDPRESS_DB_PASSWORD=wordpress
ENV WORDPRESS_DB_NAME=wordpress

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
