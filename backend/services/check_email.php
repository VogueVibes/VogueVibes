<?php
require_once('../../config/conn.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already in use!";
    } else {
        echo "Email is available!";
    }
}
?>
