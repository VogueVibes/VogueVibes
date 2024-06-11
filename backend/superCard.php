<?php
// Include necessary files and database connection
include_once __DIR__ . '/../config/conn.php';
include_once __DIR__ . '/../frontend/components/superBanner.php';

// Handle the AJAX request from the frontend
if (isset($_POST['offset'])) {
    $limit = 3;
    $offset = (int)$_POST['offset'];

    // Выбираем только товары с категорией "brand"
    $sql = "SELECT * FROM `produkte` WHERE `category` = 'brand' LIMIT $offset, $limit";
    $cards = mysqli_query($conn, $sql);

    $html = '';
    while ($good = mysqli_fetch_assoc($cards)) {
        // Generate card HTML using the function from materials.php
        $html .= generateSuperCard($good);
    }

    echo $html;
    exit();
}

// If it's a normal page load, fetch the initial cards
// Выбираем только товары с категорией "brand"
$sql = "SELECT * FROM `produkte` WHERE `category` = 'brand' LIMIT 3";
$cards = mysqli_query($conn, $sql);
?>
