#!/bin/bash
set -e

DATADIR="/data/mysql"
mkdir -p "$DATADIR"
chown -R mysql:mysql "$DATADIR"
mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld

if [ ! -d "$DATADIR/mysql" ]; then
    echo ">>> Initializing MariaDB data directory..."
    mysql_install_db --user=mysql --datadir="$DATADIR"
fi

echo ">>> Starting MariaDB..."
mysqld --datadir="$DATADIR" --user=mysql --port=3306 --bind-address=0.0.0.0 --skip-grant-tables &

for i in $(seq 1 30); do
    if mysql -u root -e "SELECT 1;" >/dev/null 2>&1; then
        echo ">>> MariaDB is ready."
        break
    fi
    echo ">>> Waiting for MariaDB... ($i/30)"
    sleep 1
done

echo ">>> Setting up database and users..."
mysql -u root <<-EOSQL
    FLUSH PRIVILEGES;
    CREATE DATABASE IF NOT EXISTS wordpress;
    DROP USER IF EXISTS 'wordpress'@'%';
    DROP USER IF EXISTS 'wordpress'@'localhost';
    DROP USER IF EXISTS 'wordpress'@'127.0.0.1';
    FLUSH PRIVILEGES;
    CREATE USER 'wordpress'@'%' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'%';
    CREATE USER 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
    CREATE USER 'wordpress'@'127.0.0.1' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'127.0.0.1';
    FLUSH PRIVILEGES;
EOSQL
echo ">>> Database ready."

echo ">>> Verifying connection..."
mysql -u wordpress -pwordpress -h 127.0.0.1 -P 3306 wordpress -e "SELECT 'connection_ok';" 2>&1 || true

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

echo ">>> Starting Apache on port ${PORT}..."
exec docker-entrypoint.sh apache2-foreground
