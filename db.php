<?php
// Database connection
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'apitesting'; 

// Create a connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
