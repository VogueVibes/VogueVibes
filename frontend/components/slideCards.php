<?php
    // Connect to the database
    include_once "../config/conn.php"; 
    include_once "../frontend/materials.php"; 
    // Check connection
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }
    // Check if the addToCart form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {
        // Retrieve product details from form data
        $itemId = $_POST['itemId'];
        $itemName = $_POST['itemName'];
        $itemPrice = $_POST['itemPrice'];
        // Add more details as needed
        
        // Check if the product is already in the user's cart
        $insertQuery = "INSERT INTO basket (itemId, itemName, itemPrice) VALUES ('$itemId', '$itemName', '$itemPrice')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "Item added to the cart successfully.";
        } else {
            echo "Error adding item to the cart: " . mysqli_error($conn);
        }
    }

    // Pagination variables
    $limit = 3; // Number of items to display per page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number, default is 1
    $offset = ($currentPage - 1) * $limit; // Offset for database query
    
    // Fetch clothing items from the database with pagination
    $query = "SELECT * FROM produkte ORDER BY RAND() LIMIT $offset, $limit";
    $result = mysqli_query($conn, $query);
    
    // Display the clothing items
    if (mysqli_num_rows($result) > 0) {
        $count = 0;
        $usedTypes = array();
        while ($row = mysqli_fetch_assoc($result)) {
  
            
            // Generate HTML for each item
            echo generateCardHTML($row);
            
            // Increment count
            $count++;
            
            // Check if it's time to start a new row
            if ($count % 3 == 0) {
                echo "</div><div class='row'>";
            }
        }
    } else {
        echo "No items found in the catalogue.";
    }

    // Close the database connection
    mysqli_close($conn);
?>
