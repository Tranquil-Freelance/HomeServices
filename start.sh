#!/bin/bash
set -e

DATADIR="/data/mysql"
WPDIR="/data/wp-content"

mkdir -p "$DATADIR" "$WPDIR"

if [ ! -d "$DATADIR/mysql" ]; then
    echo ">>> Initializing MariaDB data directory..."
    mysql_install_db --user=mysql --datadir="$DATADIR"
fi

echo ">>> Starting MariaDB for initial setup..."
mysqld_safe --datadir="$DATADIR" --skip-grant-tables &
sleep 5

echo ">>> Creating WordPress database and user..."
mysql -u root <<-EOSQL
    CREATE DATABASE IF NOT EXISTS wordpress;
    FLUSH PRIVILEGES;
    ALTER USER 'root'@'localhost' IDENTIFIED BY '';
    CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
    FLUSH PRIVILEGES;
EOSQL

echo ">>> Stopping bootstrap MariaDB..."
mysqladmin -u root shutdown || true
sleep 2

if [ -d /usr/src/wordpress/wp-content ] && [ ! -L /usr/src/wordpress/wp-content ]; then
    cp -rn /usr/src/wordpress/wp-content/* "$WPDIR/" 2>/dev/null || true
    rm -rf /usr/src/wordpress/wp-content
fi
ln -sfn "$WPDIR" /usr/src/wordpress/wp-content
chown -R www-data:www-data "$WPDIR"

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

echo ">>> Starting services via supervisord on port ${PORT}..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
