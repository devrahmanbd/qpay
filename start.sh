#!/bin/bash

MYSQLD=/nix/store/a4jsa8kjdn3wlccj2wkvhxqza38rpxzf-mariadb-server-10.11.13/bin/mysqld
BASEDIR=/nix/store/a4jsa8kjdn3wlccj2wkvhxqza38rpxzf-mariadb-server-10.11.13
DATADIR=/home/runner/mysql_data
SHAREDIR=$BASEDIR/share/mysql
SOCKET=/tmp/mysql.sock
PIDFILE=/home/runner/mysql_run/mysql.pid
WORKDIR=/home/runner/workspace

mkdir -p /home/runner/mysql_run $WORKDIR/writable/cache $WORKDIR/writable/logs $WORKDIR/writable/session $WORKDIR/writable/tmp
chmod -R 777 $WORKDIR/writable/

echo "=== QPay Startup ==="

pkill -f mysqld 2>/dev/null || true
sleep 2
rm -f $SOCKET

if [ ! -f "$DATADIR/ibdata1" ]; then
    echo "Initializing MariaDB data directory..."
    rm -rf $DATADIR
    mkdir -p $DATADIR
    $BASEDIR/bin/mysql_install_db \
        --basedir=$BASEDIR \
        --datadir=$DATADIR \
        --auth-root-authentication-method=normal \
        --user=$(whoami) 2>&1 | grep -v "auth_pam_tool" | grep -v "Operation not permitted" | grep -v "Couldn't set an owner" | grep -v "It must be root" | grep -v "Cannot change ownership"
    echo "MariaDB initialization complete."
fi

echo "Starting MariaDB..."
$BASEDIR/bin/mysqld --no-defaults \
  --basedir=$BASEDIR \
  --datadir=$DATADIR \
  --lc-messages-dir=$SHAREDIR \
  --socket=$SOCKET \
  --pid-file=$PIDFILE \
  --port=3306 \
  --bind-address=127.0.0.1 \
  --skip-networking=0 \
  --log-error=/tmp/mysqld.log &

MYSQL_PID=$!
echo "MySQL PID: $MYSQL_PID"

READY=0
for i in $(seq 1 30); do
  if mysql -S $SOCKET -u root -e "SELECT 1;" > /dev/null 2>&1; then
    echo "MySQL is ready (no password)!"
    READY=1
    break
  fi
  if mysql -S $SOCKET -u root -pharry71Nahid920* -e "SELECT 1;" > /dev/null 2>&1; then
    echo "MySQL is ready (with password)!"
    READY=2
    break
  fi
  sleep 1
done

if [ $READY -eq 0 ]; then
  echo "ERROR: MySQL failed to start. Check /tmp/mysqld.log"
  cat /tmp/mysqld.log | tail -20
  exit 1
fi

echo "Setting up database..."
if [ $READY -eq 1 ]; then
  mysql -S $SOCKET -u root << 'SQLEOF'
CREATE DATABASE IF NOT EXISTS `main` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE main;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'harry71Nahid920*';
FLUSH PRIVILEGES;
SQLEOF
elif [ $READY -eq 2 ]; then
  mysql -S $SOCKET -u root -pharry71Nahid920* << 'SQLEOF'
CREATE DATABASE IF NOT EXISTS `main` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SQLEOF
fi

MYSQL="mysql -S $SOCKET -u root -pharry71Nahid920*"

TABLE_COUNT=$($MYSQL main -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='main';" 2>/dev/null)
if [ "$TABLE_COUNT" -lt 5 ] 2>/dev/null; then
  echo "Importing database schema..."
  if [ -f "$WORKDIR/db_schema.sql" ]; then
    $MYSQL main < "$WORKDIR/db_schema.sql" 2>&1
    echo "Schema imported from db_schema.sql"
  fi
fi

$MYSQL main << 'SQLTABLES'
INSERT IGNORE INTO `user_roles` (`id`, `name`, `permissions`)
VALUES (1, 'Super Admin', '*');

INSERT IGNORE INTO `staffs` (`id`, `ids`, `email`, `first_name`, `last_name`, `role_id`, `password`, `status`, `created_at`)
VALUES (1, 'admin', 'admin@cloudman.one', 'Admin', '', 1, '$2y$10$JUo3XOgK8cbHV605rLF3TujR0dUQGdqlZuWeV/Mige8JYGsh1NbzO', 1, NOW());
SQLTABLES

echo "Database and tables setup done."

echo "Running migrations..."
cd $WORKDIR
php spark migrate --all 2>&1 || true
echo "Migrations done."

echo "Starting PHP server on 0.0.0.0:5000..."
exec php -S 0.0.0.0:5000 -t $WORKDIR $WORKDIR/router.php
