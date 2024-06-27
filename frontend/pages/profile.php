<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
include "../../config/conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Handle image upload
if (isset($_POST['upload_image'])) {
    if (empty($_FILES["profile_image"]["name"])) {
        echo "Please select a file to upload.";
    } else {
        uploadProfileImage($user_id, $conn);
    }
}

// Function to upload profile image
function uploadProfileImage($user_id, $conn) {
    $target_dir = "../img/profile/";
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die("Failed to create directory: " . $target_dir);
        }
    }

    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Update user's profile image in database
            $sql_update = "UPDATE `user` SET profile_image = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('si', basename($target_file), $user_id); // Save only the filename
            if ($stmt_update->execute()) {
                echo "The file ". htmlspecialchars(basename($_FILES["profile_image"]["name"])). " has been uploaded.";
                // Refresh user data
                refreshUserData($user_id, $conn);
            } else {
                echo "Failed to update database: " . $stmt_update->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Function to refresh user data after upload
function refreshUserData($user_id, $conn) {
    $sql = "SELECT * FROM `user` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    global $user;
    $user = $result->fetch_assoc();
}

// Function to get user's profile image path
function getProfileImagePath($user) {
    $profileDir = "../img/profile/";
    if (!empty($user['profile_image']) && file_exists($profileDir . $user['profile_image'])) {
        return $profileDir . $user['profile_image'];
    } else {
        return "../img/workpieces/blackMask.png"; // Default image
    }
}

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

// Function to determine the image path for cart and purchased items
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
   
        /* General Styles */
        body, html {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('../img/workpieces/fon_prof.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            width: 100%;
        }

        .profile-container {
            max-width: 1200px;
            margin: 90px auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 15px;
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

        /* Responsive Styles */
        @media (max-width: 768px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 10px;
            }

            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-header img {
                margin: 0 0 10px 0;
            }

            .profile-header h1 {
                font-size: 20px;
            }

            .cart-item, .purchased-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item img, .purchased-item img {
                margin-bottom: 10px;
            }

            .purchased-item-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-actions a {
                display: block;
                margin: 5px 0;
            }
        }

        @media (max-width: 480px) {
            .profile-header h1 {
                font-size: 18px;
            }

            .cart-title, .purchased-title {
                font-size: 18px;
            }

            .profile-info p, .cart-item p, .purchased-item p {
                font-size: 14px;
            }

            .pay-all {
                padding: 8px;
                font-size: 14px;
            }

            .upload-form {
                width: 100%;
                padding: 10px;
            }

            .upload-form input[type="file"] {
                width: 90%;
                padding: 5px;
            }

            .upload-form button {
                width: 90%;
                padding: 10px;
                font-size: 14px;
            }
        }

        .upload-form {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            margin: 20px auto;
        }

        .upload-form input[type="file"] {
            display: block;
            margin: 10px auto;
            padding: 10px;
        }

        .upload-form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .upload-form button:hover {
            background-color: #0056b3;
        }

        .profile-section {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #message {
            margin-top: 10px;
            padding: 10px;
            display: none;
        }

        #message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        #message.success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-block">
            <div class="profile-header">
                <img src="<?php echo getProfileImagePath($user); ?>" alt="User Avatar" width="80" height="80">
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
                <div class="profile-section">
                    <div class="upload-form">
                        <h2>Upload Profile Image</h2>
                        <form action="profile.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profile_image" accept="image/*">
                            <button type="submit" name="upload_image">Upload Image</button>
                        </form>
                    </div>
                </div>
                <a href="edit_profile.php">Edit Profile</a>
                <a href="../../backend/logout.php">Logout</a>
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
                <a href="#" class="pay-all">Pay All</a>
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
