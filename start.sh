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

# Kill any existing mysql
pkill -f mysqld 2>/dev/null || true
sleep 2
rm -f $SOCKET

# Initialize data directory if needed (check for InnoDB system files)
if [ ! -f "$DATADIR/ibdata1" ]; then
    echo "Initializing MariaDB data directory..."
    rm -rf $DATADIR
    mkdir -p $DATADIR
    # Ignore PAM errors (non-critical)
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

# Wait for MySQL to be ready
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

# Setup database, password, and tables
echo "Setting up database..."
if [ $READY -eq 1 ]; then
  # No password yet - set up everything
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

# Create all required tables
mysql -S $SOCKET -u root -pharry71Nahid920* main << 'SQLTABLES'
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `sort` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `staffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT 1,
  `more_information` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `activation_key` varchar(255) DEFAULT NULL,
  `reset_key` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `api_credentials` text DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `ref_key` varchar(255) DEFAULT NULL,
  `addons` text DEFAULT NULL,
  `more_information` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `activation_key` varchar(255) DEFAULT NULL,
  `reset_key` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `admin_activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `amount` decimal(10,3) DEFAULT 0.000,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_payment_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `credentials` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `module_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ticket_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `website` int(11) DEFAULT 0,
  `device` int(11) DEFAULT 0,
  `transaction` int(11) DEFAULT 0,
  `final_price` decimal(10,2) DEFAULT 0.00,
  `duration` int(11) DEFAULT 30,
  `duration_type` varchar(50) DEFAULT 'days',
  `brand` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `brand_key` varchar(255) DEFAULT NULL,
  `brand_logo` varchar(255) DEFAULT NULL,
  `meta` text DEFAULT NULL,
  `fees` decimal(10,2) DEFAULT 0.00,
  `fees_type` varchar(50) DEFAULT 'fixed',
  `currency` varchar(10) DEFAULT 'BDT',
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `device_key` varchar(255) DEFAULT NULL,
  `device_ip` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT 'fixed',
  `price` decimal(10,2) DEFAULT 0.00,
  `times` int(11) DEFAULT 0,
  `used` int(11) DEFAULT 0,
  `param` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'BDT',
  `fees` decimal(10,2) DEFAULT 0.00,
  `status` tinyint(1) DEFAULT 0,
  `transaction_id` varchar(255) DEFAULT NULL,
  `more_information` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `temp_transactions` LIKE `transactions`;

CREATE TABLE IF NOT EXISTS `bank_transaction_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `status` tinyint(1) DEFAULT 0,
  `log_data` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `is_admin_read` tinyint(1) DEFAULT 0,
  `admin_status` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `permissions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `ticket_id` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `support` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `admin_read` tinyint(1) DEFAULT 0,
  `user_read` tinyint(1) DEFAULT 0,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `kyc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `document_type` varchar(100) DEFAULT NULL,
  `document_front` varchar(255) DEFAULT NULL,
  `document_back` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ids` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_number` varchar(100) DEFAULT NULL,
  `customer_amount` decimal(10,2) DEFAULT 0.00,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `pay_status` tinyint(1) DEFAULT 0,
  `brand_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `extras` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `user_roles` (`id`, `name`, `permissions`)
VALUES (1, 'Super Admin', '*');

INSERT IGNORE INTO `staffs` (`id`, `ids`, `email`, `first_name`, `last_name`, `role_id`, `password`, `status`)
VALUES (1, '1', 'admin@qpay.com', 'Admin', 'User', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

INSERT IGNORE INTO `faqs` (`question`, `answer`, `sort`, `status`) VALUES
('What is QPay?', 'QPay is a comprehensive payment gateway platform that allows businesses to accept payments easily and securely.', 1, 1),
('How do I get started?', 'Sign up for an account, choose a plan that fits your business needs, and start integrating our payment APIs.', 2, 1),
('What payment methods are supported?', 'We support multiple payment methods including credit cards, bank transfers, and mobile banking.', 3, 1);
SQLTABLES

echo "Database and tables setup done."

# Run migrations
echo "Running migrations..."
cd $WORKDIR
php spark migrate --all -n Home 2>&1 || true
php spark migrate --all -n Blocks 2>&1 || true
echo "Migrations done."

# Start PHP built-in server
echo "Starting PHP server on 0.0.0.0:5000..."
exec php -S 0.0.0.0:5000 -t $WORKDIR $WORKDIR/router.php
