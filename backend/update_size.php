<?php
session_start();
include "../config/conn.php";

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log errors
function log_error($message) {
    $log_file = '/tmp/update_size_errors.log';
    file_put_contents($log_file, date('Y-m-d H:i:s') . ' - ' . $message . "\n", FILE_APPEND);
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    log_error('User not logged in.');
    exit();
}

// Log incoming POST data for debugging
log_error('Incoming POST data: ' . json_encode($_POST));

// Validate POST data
if (!isset($_POST['item_id']) || !isset($_POST['new_size'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    log_error('Invalid request: ' . json_encode($_POST));
    exit();
}

$user_id = $_SESSION['id'];
$item_id = $_POST['item_id'];
$new_size = $_POST['new_size'];

// Prepare the SQL query
$update_query = "UPDATE `basket` SET size=? WHERE id=? AND user_id=?";
$stmt = $conn->prepare($update_query);

if ($stmt) {
    $stmt->bind_param("sii", $new_size, $item_id, $user_id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Size updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No changes made or item not found.']);
            log_error('No changes made or item not found.');
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
        log_error('Execute failed: ' . $stmt->error);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    log_error('Prepare failed: ' . $conn->error);
}

$conn->close();
?>
