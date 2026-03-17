<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'online_store');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("DB Connection failed: " . $conn->connect_error);
$conn->set_charset('utf8mb4');

define('PAYMONGO_SECRET', ''); // Replace with your PayMongo secret key
define('BASE_URL', 'http://localhost/online_store_mvc/public');

?>