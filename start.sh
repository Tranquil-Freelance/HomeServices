#!/bin/bash
set -e

DATADIR="/data/mysql"
mkdir -p "$DATADIR"

if [ ! -d "$DATADIR/mysql" ]; then
    echo ">>> Initializing MariaDB data directory..."
    mysql_install_db --user=mysql --datadir="$DATADIR"
fi

echo ">>> Starting MariaDB for initial setup..."
mysqld_safe --datadir="$DATADIR" --skip-grant-tables &

for i in $(seq 1 30); do
    if mysqladmin ping --silent 2>/dev/null; then
        echo ">>> MariaDB is ready."
        break
    fi
    echo ">>> Waiting for MariaDB... ($i/30)"
    sleep 1
done

echo ">>> Creating WordPress database and user..."
mysql -u root <<-EOSQL
    FLUSH PRIVILEGES;
    CREATE DATABASE IF NOT EXISTS wordpress;
    CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
    FLUSH PRIVILEGES;
EOSQL

echo ">>> Stopping bootstrap MariaDB..."
mysqladmin -u root shutdown || true
sleep 2

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

echo ">>> Starting services via supervisord on port ${PORT}..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
