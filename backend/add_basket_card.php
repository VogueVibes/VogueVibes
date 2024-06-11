<?php 
include "../config/conn.php";
include_once __DIR__ . '/../frontend/components/materials.php';
include_once __DIR__ . '/../frontend/components/superBanner.php';
session_start();
$user_id=$_SESSION['id'];
if(!isset($user_id)){
    header('location:../frontend/login.php');
}

if (isset($_POST['addToCart'])) {
    $product_image = $_POST['image'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_category=$_POST['category'];
    $quantity = 1;
    $size='S';

    $select_cart = mysqli_query($conn, "SELECT * FROM `basket` WHERE name='$product_name' AND user_id='$user_id'");
    var_dump($_POST);
    if (mysqli_num_rows($select_cart) > 0) {
        echo ("Already");
    } else {
        // Use proper quotes around values in the SQL query
        $insert_product = mysqli_query($conn, "INSERT INTO `basket` (user_id,name, price, image, quantity,size, category) VALUES ('$user_id','$product_name', '$product_price', '$product_image', '$quantity','$size','$product_category')");
    }
}


?>
