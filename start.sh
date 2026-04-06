#!/bin/bash
set -e

DATADIR="/data/mysql"
mkdir -p "$DATADIR"
chown -R mysql:mysql "$DATADIR"
mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld

FIRST_RUN=false
if [ ! -d "$DATADIR/mysql" ]; then
    echo ">>> First run: initializing MariaDB..."
    mysql_install_db --user=mysql --datadir="$DATADIR"
    FIRST_RUN=true
fi

if [ "$FIRST_RUN" = "true" ]; then
    echo ">>> Starting MariaDB with skip-grant-tables for setup..."
    mysqld --datadir="$DATADIR" --user=mysql --skip-grant-tables --skip-networking &
    MYSQL_PID=$!

    for i in $(seq 1 30); do
        if mysqladmin ping --silent 2>/dev/null; then
            echo ">>> MariaDB ready."
            break
        fi
        sleep 1
    done

    echo ">>> Creating database and user..."
    mysql -u root <<-EOSQL
        FLUSH PRIVILEGES;
        CREATE DATABASE IF NOT EXISTS wordpress;
        CREATE USER 'wordpress'@'%' IDENTIFIED BY 'wordpress';
        GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'%';
        FLUSH PRIVILEGES;
EOSQL
    echo ">>> Setup done, stopping MariaDB..."
    kill $MYSQL_PID
    wait $MYSQL_PID 2>/dev/null || true
    sleep 1
fi

echo ">>> Starting MariaDB (normal mode)..."
mysqld --datadir="$DATADIR" --user=mysql --port=3306 --bind-address=127.0.0.1 &

for i in $(seq 1 30); do
    if mysqladmin ping --silent 2>/dev/null; then
        echo ">>> MariaDB is running."
        break
    fi
    echo ">>> Waiting for MariaDB... ($i/30)"
    sleep 1
done

echo ">>> Testing DB connection..."
if mysql -u wordpress -pwordpress -h 127.0.0.1 -P 3306 wordpress -e "SELECT 1 AS test;" 2>&1; then
    echo ">>> DB connection OK!"
else
    echo ">>> DB connection failed, trying socket..."
    mysql -u wordpress -pwordpress wordpress -e "SELECT 1 AS test;" 2>&1 || echo ">>> Socket also failed"
fi

PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

echo ">>> Starting Apache via WordPress entrypoint on port ${PORT}..."
exec docker-entrypoint.sh apache2-foreground
