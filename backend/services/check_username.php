<?php
require_once('../../config/conn.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username is already in use!";
    } else {
        echo "Username is available!";
    }
}
?>
