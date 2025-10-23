<?php
// Database configuration
define('DB_HOST', 'sql210.infinityfree.com');
define('DB_USER', 'if0_40199430');
define('DB_PASS', 'chennai93910');
define('DB_NAME', 'if0_40199430_eventdb');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");
?>