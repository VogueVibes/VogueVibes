<?php 
// Include necessary files and start session
include "../config/conn.php";
include_once __DIR__ . '/../frontend/components/materials.php';
include_once __DIR__ . '/../frontend/components/superBanner.php';
session_start();

// Get user ID from session and check if user is logged in
$user_id = $_SESSION['id'];
if (!isset($user_id)) {
    header('location:../frontend/login.php');
    exit();
}

// Check if the add to cart form has been submitted
if (isset($_POST['addToCart'])) {
    // Retrieve product details from form data
    $product_image = $_POST['image'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_category = $_POST['category'];
    $quantity = 1; // Default quantity
    $size = 'S'; // Default size

    // Check if the product is already in the user's cart
    $select_cart = mysqli_query($conn, "SELECT * FROM `basket` WHERE name='$product_name' AND user_id='$user_id'");
    var_dump($_POST); // Debugging output to see form data

    if (mysqli_num_rows($select_cart) > 0) {
        // Product is already in the cart
        echo ("Already in cart");
    } else {
        // Insert the product into the cart
        $insert_product = mysqli_query($conn, "INSERT INTO `basket` (user_id, name, price, image, quantity, size, category) VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$quantity', '$size', '$product_category')");
    }
}
?>
