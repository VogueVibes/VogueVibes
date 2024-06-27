<?php
// Include database connection file
require_once('../../config/conn.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare and execute the SQL statement to check if the email exists
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the email is already in use
    if ($result->num_rows > 0) {
        echo "Email is already in use!";
    } else {
        echo "Email is available!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
