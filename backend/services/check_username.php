<?php
// Include database connection file
require_once('../../config/conn.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Prepare and execute the SQL statement to check if the username exists
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the username is already in use
    if ($result->num_rows > 0) {
        echo "Username is already in use!";
    } else {
        echo "Username is available!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
