<?php
include "../config/conn.php";  // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['new_size'])) {
    $product_id = $_POST['product_id'];
    $new_size = $_POST['new_size'];

    $query = "UPDATE `basket` SET size=? WHERE id=?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("si", $new_size, $product_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Size updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No changes made or item not found.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
$conn->close();
?>
