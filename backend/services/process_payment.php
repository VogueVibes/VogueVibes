<?php
session_start();
include "../../config/conn.php";

// Redirect to login page if user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];
    $total_price = $_POST['total_price'];

    // Simulate payment processing
    $payment_success = true;

    if ($payment_success) {
        // Move items from basket to purchased table
        $sql_cart = "SELECT * FROM basket WHERE user_id = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param('i', $user_id);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();

        // Process each item in the basket
        while ($item = $result_cart->fetch_assoc()) {
            $sql_purchased = "INSERT INTO purchased (user_id, name, price, image, size, category, tracking_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_purchased = $conn->prepare($sql_purchased);
            $tracking_code = 'TRK' . strtoupper(bin2hex(random_bytes(5)));
            $stmt_purchased->bind_param('isdsiss', $user_id, $item['name'], $item['price'], $item['image'], $item['size'], $item['category'], $tracking_code);
            $stmt_purchased->execute();
        }

        // Clear the basket after purchase
        $sql_clear_basket = "DELETE FROM basket WHERE user_id = ?";
        $stmt_clear_basket = $conn->prepare($sql_clear_basket);
        $stmt_clear_basket->bind_param('i', $user_id);
        $stmt_clear_basket->execute();

        // Redirect to success page after successful purchase
        header('Location: success.php');
        exit();
    } else {
        // Redirect to checkout page with error message if payment fails
        header('Location: checkout.php?error=Payment failed. Please try again.');
        exit();
    }
} else {
    // Redirect to checkout page if the request method is not POST
    header('Location: checkout.php');
    exit();
}
?>
