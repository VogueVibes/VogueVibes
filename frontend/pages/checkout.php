<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
include "../../config/conn.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user's cart items
$sql_cart = "SELECT name, price, quantity FROM basket WHERE user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

$cart_items = [];
$total_price = 0;
while ($item = $result_cart->fetch_assoc()) {
    $cart_items[] = $item;
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .checkout-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .checkout-form {
            display: flex;
            flex-direction: column;
        }

        .checkout-form input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .checkout-form button {
            padding: 10px;
            font-size: 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-summary {
            margin-bottom: 20px;
        }

        .checkout-summary p {
            margin: 0;
            font-size: 16px;
        }

        .total-price {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Checkout</h1>
        </div>
        <div class="checkout-summary">
            <h2>Order Summary</h2>
            <?php foreach ($cart_items as $item): ?>
                <p><?php echo htmlspecialchars($item['name']); ?> x <?php echo $item['quantity']; ?> - $<?php echo $item['price']; ?> each</p>
            <?php endforeach; ?>
            <p class="total-price">Total: $<?php echo $total_price; ?></p>
        </div>
        <form class="checkout-form" action="process_payment.php" method="POST">
            <input type="text" name="card_number" placeholder="Card Number" required>
            <input type="text" name="card_expiry" placeholder="Expiry Date (MM/YY)" required>
            <input type="text" name="card_cvc" placeholder="CVC" required>
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <button type="submit">Pay Now</button>
        </form>
    </div>
    <script src="../JS/script.js"></script>
</body>
</html>
