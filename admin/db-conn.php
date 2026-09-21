<?php
if (session_status() === PHP_SESSION_NONE) {
    // session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Database Configuration
$local = true; 

if ($local) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'avacado';
    $site = "http://localhost/office_php_project/avacado/";
} else {
    $host = 'localhost';
    $username = 'u776339737_avacado_db';
    $password = 'Avacado@traders1';
    $dbName = 'u776339737_avacado_db';
    $site = 'https://slategray-cobra-224159.hostingersite.com/';
}

// Make `$site` global
global $site;

// Create Database Connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: Set Character Encoding to UTF-8
$conn->set_charset("utf8");

?>