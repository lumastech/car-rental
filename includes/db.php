<?php
 $env = parse_ini_file(__DIR__ . '../../.env');
// Database connection (modify these credentials as per your setup)

if($env['DB_HOST'] == null || $env['DB_USER'] == null ||  $env['DB_NAME'] == null){
    header('Location: /setup/index.php');
    exit();
}

$dbHost = $env['DB_HOST'];
$dbUser = $env['DB_USER'];
$dbPass = $env['DB_PASSWORD'];
$dbName = $env['DB_NAME'];

// Create a database connection
$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check for database connection errors
if ($db->connect_error) {
    header('Location: /setup/index.php');
    die("Connection failed: " . $db->connect_error);
}

?>