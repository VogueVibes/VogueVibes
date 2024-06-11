<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
include "../../config/conn.php";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user details from the database
$sql = "SELECT * FROM `user` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

// Fetch user cart items from the basket table
$sql_cart = "SELECT name, price, image, quantity, size, category FROM basket WHERE user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

$cart_items = [];
while ($item = $result_cart->fetch_assoc()) {
    $cart_items[] = $item;
}

// Fetch purchased items
$sql_purchased = "SELECT name, price, image, size, category FROM purchased WHERE user_id = ?";
$stmt_purchased = $conn->prepare($sql_purchased);
$stmt_purchased->bind_param('i', $user_id);
$stmt_purchased->execute();
$result_purchased = $stmt_purchased->get_result();

$purchased_items = [];
while ($item = $result_purchased->fetch_assoc()) {
    $item['tracking_code'] = 'TRK' . strtoupper(bin2hex(random_bytes(5))); // Generate random tracking code
    $purchased_items[] = $item;
}

// Function to determine the image path
function getImagePath($item) {
    $baseDir = '../img/';
    $brandDir = 'exclusive/';
    $regularDir = 'catalogue/';

    if ($item['category'] === 'brand') {
        $path = $baseDir . $brandDir . $item['image'];
    } else {
        $path = $baseDir . $regularDir . $item['image'];
    }

    // Check if file exists on server
    if (file_exists($path)) {
        return $path;
    } else {
        return $baseDir . 'default.png'; // Default image if not found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Add your CSS file path here -->
    <style>
        /* Profile Page CSS */
        body {
            font-family: Arial, sans-serif;
            background: url('../img/workpieces/fon_prof.jpeg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        .profile-container {
            max-width: 1200px;
            margin: 90px auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .profile-block, .cart-block, .purchased-block {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .profile-header {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .profile-header img {
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .profile-header p {
            margin: 5px 0 0;
            color: #777;
        }

        .profile-info p, .cart-item p, .purchased-item p {
            margin: 0;
            color: #333;
        }

        .profile-actions {
            margin-top: 20px;
            text-align: center;
        }

        .profile-actions a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }

        .cart-title, .purchased-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .cart-item, .purchased-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .cart-item img, .purchased-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 10px;
        }

        .pay-all {
            display: block;
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
            cursor: pointer;
            text-decoration: none;
        }

        .purchased-block {
            grid-column: span 2;
        }

        .purchased-item-info {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }

        .purchased-item-info-left {
            display: flex;
            flex-direction: column;
        }

      

    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-block">
            <div class="profile-header">
                <img src="../images/profile-avatar.png" alt="User Avatar" width="80" height="80">
                <div>
                    <h1><?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?></h1>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                    <p><?php echo htmlspecialchars($user['username']); ?></p>
                </div>
            </div>
            <div class="profile-info">
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($user['anrede']); ?></p>
            </div>
            <div class="profile-actions">
                <a href="edit_profile.php">Edit Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="cart-block">
            <div class="cart-title">My Cart Items</div>
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="<?php echo getImagePath($item); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <p><?php echo htmlspecialchars($item['name']); ?> - Size: <?php echo htmlspecialchars($item['size']); ?></p>
                        <p><?php echo htmlspecialchars($item['quantity']); ?> x $<?php echo htmlspecialchars($item['price']); ?></p>
                    </div>
                <?php endforeach; ?>
                <a href="checkout.php" class="pay-all">Pay All</a>
            <?php else: ?>
                <p>No items in cart.</p>
            <?php endif; ?>
        </div>

        <div class="purchased-block">
            <div class="purchased-title">Purchased Items</div>
            <?php if (!empty($purchased_items)): ?>
                <?php foreach ($purchased_items as $item): ?>
                    <div class="purchased-item">
                        <img src="<?php echo getImagePath($item); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="purchased-item-info">
                            <p><?php echo htmlspecialchars($item['name']); ?> - Size: <?php echo htmlspecialchars($item['size']); ?></p>
                            <p>$<?php echo htmlspecialchars($item['price']); ?></p>
                            <p class="tracking-code">Tracking Code: <?php echo htmlspecialchars($item['tracking_code']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No purchased items found.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="../JS/script.js"></script>
</body>
</html>
