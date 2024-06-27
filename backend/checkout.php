<?php
session_start();
include "../config/conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Function to log errors to a file
function log_error($message) {
    $log_file = '../../logs/checkout_errors.log';
    file_put_contents($log_file, date('Y-m-d H:i:s') . ' - ' . $message . "\n", FILE_APPEND);
}

if (!isset($_SESSION['id'])) {
    // If user is not logged in, return error
    $response = array('success' => false, 'message' => 'User not logged in.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['id'];

// Start a transaction
mysqli_begin_transaction($conn);

try {
    // Step 1: Retrieve the items from the `basket` table
    $cart_query = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='$user_id'");
    if (!$cart_query) {
        throw new Exception('Query failed: ' . mysqli_error($conn));
    }

    // Step 2: Insert these items into the `purchased` table
    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
        $item_id = $fetch_cart['id'];
        $item_user_id = $fetch_cart['user_id'];
        $item_name = $fetch_cart['name'];
        $item_price = $fetch_cart['price'];
        $item_image = $fetch_cart['image'];
        $item_size = $fetch_cart['size'];
        $item_category = $fetch_cart['category'];
        $item_quantity = $fetch_cart['quantity'];
        $purchase_date = date('Y-m-d H:i:s');
        $tracking_code = ''; // Add tracking code logic if needed

        // Insert into `purchased` table
        $insert_query = "INSERT INTO `purchased` (user_id, name, price, image, size, category, purchase_date, tracking_code)
                         VALUES ('$item_user_id', '$item_name', '$item_price', '$item_image', '$item_size', '$item_category', '$purchase_date', '$tracking_code')";
        if (!mysqli_query($conn, $insert_query)) {
            throw new Exception('Insert Query failed: ' . mysqli_error($conn));
        }
    }

    // Step 3: Delete these items from the `basket` table
    $delete_query = "DELETE FROM `basket` WHERE user_id='$user_id'";
    if (!mysqli_query($conn, $delete_query)) {
        throw new Exception('Delete Query failed: ' . mysqli_error($conn));
    }

    // Commit the transaction
    mysqli_commit($conn);

    $response = ['success' => true];
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    mysqli_rollback($conn);
    $response = ['success' => false, 'message' => $e->getMessage()];
    log_error($e->getMessage()); // Log the error message
}

header('Content-Type: application/json');
echo json_encode($response);
?>
