#!/bin/bash
set -e

echo ">>> Ensuring writable uploads directory..."
mkdir -p /var/www/html/wp-content/uploads
chown -R www-data:www-data /var/www/html/wp-content/uploads
chmod -R 755 /var/www/html/wp-content/uploads
chown -R www-data:www-data /var/www/html/wp-content/plugins 2>/dev/null || true
chown -R www-data:www-data /var/www/html/wp-content/themes 2>/dev/null || true

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

echo ">>> Starting Apache on port ${PORT} (database is external)..."
exec docker-entrypoint.sh apache2-foreground
