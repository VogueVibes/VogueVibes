<?php 

// Check if the card ID for deletion was sent
if (isset($_POST['cardId'])) {
    $cardId = $_POST['cardId'];

    // Include database connection
    include "../config/conn.php";

    // Prepare and execute SQL query to delete the record
    $query = "DELETE FROM `basket` WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cardId);
    $result = $stmt->execute();

    // Check if the query was successful
    if ($result) {
        // Successfully deleted
        $response = array('statusCode' => 200, 'message' => 'Card deleted successfully.');
    } else {
        // Error while deleting
        $response = array('statusCode' => 500, 'message' => 'Failed to delete the card.');
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // Important to terminate the script after sending JSON response
}
?>
