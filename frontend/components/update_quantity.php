<?php
session_start();

// Connect to the database
include_once "../config/conn.php";

// Check connection
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Check if the 'counter' and 'itemId' values are provided
if (isset($_POST['counter'], $_POST['itemId'])) {
    $counter = intval($_POST['counter']);
    $itemId = $_POST['itemId'];

    // Update the quantity in the database
    $updateQuery = "UPDATE basket SET quantity = $counter WHERE itemId = $itemId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Quantity updated successfully
        echo "success";
    } else {
        // Failed to update quantity
        echo "error";
    }
} else {
    // 'counter' or 'itemId' values are not provided
    echo "error";
}

mysqli_close($conn);
?>
