FROM wordpress:6.7-php8.2-apache

COPY ashade/ /usr/src/wordpress/wp-content/themes/ashade/
COPY ashade-child/ /usr/src/wordpress/wp-content/themes/ashade-child/

RUN chown -R www-data:www-data /usr/src/wordpress/wp-content/themes/ashade \
    /usr/src/wordpress/wp-content/themes/ashade-child

EXPOSE 80

ENV WORDPRESS_DB_HOST=${WORDPRESS_DB_HOST}
ENV WORDPRESS_DB_USER=${WORDPRESS_DB_USER}
ENV WORDPRESS_DB_PASSWORD=${WORDPRESS_DB_PASSWORD}
ENV WORDPRESS_DB_NAME=${WORDPRESS_DB_NAME}
