<?php
$server = "localhost";
$db = "itprojeckt";
$user = "root";
$pwd = "";

$conn = new mysqli($server, $user, $pwd, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;
?>
