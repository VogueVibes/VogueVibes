<?php
include_once "../config/conn.php"; // Database connection
include "../backend/superCard.php"; // Script to generate HTML cards



if (isset($_POST['id']) && isset($_POST['dir'])) {
    $currentId = (int)$_POST['id'];
    $direction = $_POST['dir'];

    // Adjust the query to filter by the 'brand' category
    $query = $direction === 'next' ?
        "SELECT * FROM `produkte` WHERE `itemId` > ? AND `category` = 'brand' ORDER BY `itemId` ASC LIMIT 1" :
        "SELECT * FROM `produkte` WHERE `itemId` < ? AND `category` = 'brand' ORDER BY `itemId` DESC LIMIT 1";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $currentId); // Bind the integer parameter for the item ID
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($good = mysqli_fetch_assoc($result)) {
            echo json_encode([
                'html' => generateSuperCard($good),
                'endOfData' => false
            ]);
        } else {
            echo json_encode(['endOfData' => true]); // No more data available
        }

        mysqli_stmt_close($stmt); // Close statement
    } else {
        // Handle errors related to statement preparation
        echo json_encode(['error' => 'Database error: Unable to prepare statement']);
    }
} 
?>
