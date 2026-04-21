<?php
require 'vendor/autoload.php';
$config = new \Config\Database();
echo "Default Database: " . $config->default['database'] . "\n";
echo "Default Username: " . $config->default['username'] . "\n";
