<?php
session_start();
include "../../config/conn.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];
    $total_price = $_POST['total_price'];

    // Simulate payment processing
    $payment_success = true;

    if ($payment_success) {
        // Move items from basket to purchased
        $sql_cart = "SELECT * FROM basket WHERE user_id = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param('i', $user_id);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();

        while ($item = $result_cart->fetch_assoc()) {
            $sql_purchased = "INSERT INTO purchased (user_id, name, price, image, size, category, tracking_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_purchased = $conn->prepare($sql_purchased);
            $tracking_code = 'TRK' . strtoupper(bin2hex(random_bytes(5)));
            $stmt_purchased->bind_param('isdsiss', $user_id, $item['name'], $item['price'], $item['image'], $item['size'], $item['category'], $tracking_code);
            $stmt_purchased->execute();
        }

        // Clear the basket
        $sql_clear_basket = "DELETE FROM basket WHERE user_id = ?";
        $stmt_clear_basket = $conn->prepare($sql_clear_basket);
        $stmt_clear_basket->bind_param('i', $user_id);
        $stmt_clear_basket->execute();

        header('Location: success.php');
        exit();
    } else {
        header('Location: checkout.php?error=Payment failed. Please try again.');
        exit();
    }
} else {
    header('Location: checkout.php');
    exit();
}
?>
