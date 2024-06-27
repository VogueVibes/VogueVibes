<?php
// Include database connection file
include_once '../../config/conn.php';

if (isset($_POST['add_card'])) {
    // Retrieve and sanitize form data
    $typeName = (string)$_POST['typeName'];
    $itemName = (string)$_POST['itemName'];
    $itemPrice = (string)$_POST['itemPrice'];
    $itemDescription = (string)$_POST['itemDescription'];
    $category = (string)$_POST['category']; // Correct the array key to 'category'
    $photo_name = $_FILES['itemImage']['name'];

    // Get the temporary file name on the server
    $tmp_file = $_FILES['itemImage']['tmp_name'];

    // Ensure the destination directory exists
    $destination_dir = "../../frontend/img/catalogue/";
    if (!is_dir($destination_dir)) {
        mkdir($destination_dir, 0777, true);
    }

    // Move the uploaded file to the destination folder
    $destination = $destination_dir . $photo_name;
    if (move_uploaded_file($tmp_file, $destination)) {
        // Define the path to the image file
        $itemImage = $photo_name;

        // Insert the form data into the database
        $query = "
        INSERT INTO `produkte`(
            `itemName`,
            `itemPrice`,
            `itemImage`,
            `itemDescription`,
            `typeName`,
            `category`
        ) VALUES (
            '$itemName',
            '$itemPrice',
            '$itemImage',
            '$itemDescription',
            '$typeName',
            '$category'
        )
        ";

        if ($conn->query($query) === TRUE) {
            // Redirect to the admin page on success
            header("location: admin.php");
            exit();
        } else {
            // Display an error message if the query fails
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        // Display an error message if the file upload fails
        echo "Error uploading file.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
