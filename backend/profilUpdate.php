<?php
session_start();
require_once 'config/conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get user details from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT firstname, lastname, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Handle post request for profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $email = $_POST['email'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the database
    $update_stmt = $conn->prepare("UPDATE users SET email = ?, password = ? WHERE id = ?");
    $update_stmt->bind_param("ssi", $email, $hashed_password, $user_id);
    $update_stmt->execute();

    // Optionally handle file upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $upload_dir = 'uploads/';
        $filename = $upload_dir . basename($_FILES['profile_photo']['name']);
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $filename);
        // Update the database with the new profile photo path if needed
    }

    // Refresh session data or redirect
    header("Location: profile.php");
    exit();
}
?>
