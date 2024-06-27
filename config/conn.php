<?php
$server = "localhost";
$db = "software_db";
$user = "root";
$pwd = "";

// Create a new MySQLi connection
$conn = new mysqli($server, $user, $pwd, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the connection is returned for inclusion in other scripts
return $conn;
?>
