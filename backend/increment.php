<?php

// Check if the cardId and quantity are provided in the POST request
if (isset($_POST['cardId']) && isset($_POST['quantity'])) {
    $cardId = $_POST['cardId'];
    $quantity = $_POST['quantity'];

    // Validate the inputs if necessary

    // Perform the update query to decrement the quantity
    // Assuming your table structure is `basket` with columns `id` and `quantity`
    include "../config/conn.php";

    // Decrement the quantity by 1
    $query = "UPDATE `basket` SET quantity = quantity + 1 WHERE id = $cardId";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $response = array('statusCode' => 200, 'message' => 'Quantity updated successfully.');
    } else {
        $response = array('statusCode' => 500, 'message' => 'Failed to update the quantity.');
    }

    // Send JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // Important to terminate the script after sending the JSON response
}
?>