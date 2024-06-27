<?php
// Start the session if not already started
session_start();

// Connect to the database
include_once "../config/conn.php";

// Allow cross-origin requests
header('Access-Control-Allow-Origin: *');

// Get the user ID from the session
if (!isset($_SESSION['id'])) {
    // If user is not logged in, return error
    $response = array('statusCode' => 401, 'message' => 'User not logged in.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['id'];

// Fetch all items in the basket for the user
$cart_query = mysqli_query($conn, "SELECT id, name, price, quantity FROM `basket` WHERE user_id='$user_id'") or die('Query failed');

$items = array();
$totalPrice = 0;
$totalQuantity = 0;

while ($row = mysqli_fetch_assoc($cart_query)) {
    // Calculate the total price for each item
    $itemTotal = $row['price'] * $row['quantity'];
    $totalPrice += $itemTotal;
    $totalQuantity += $row['quantity'];

    // Add each item to the $items array
    $item = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => $row['price'], // Add this line
        'quantity' => $row['quantity'],
        'total' => $itemTotal
    );
    $items[] = $item;
}

// Return the total, total quantity, and items array as a JSON response
$response = array(
    'statusCode' => 200,
    'total' => $totalPrice,
    'quantity' => $totalQuantity,
    'items' => $items
);

header('Content-Type: application/json');
echo json_encode($response);

exit();
?>
