<?php

// Function to check the database connection
if (!function_exists('check_db_connection')) {
    function check_db_connection($server, $user, $pwd, $db, $port = 3306, $socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock") {
        $conn = new mysqli($server, $user, $pwd, $db, $port, $socket);
        if ($conn->connect_error) {
            throw new mysqli_sql_exception($conn->connect_error, $conn->connect_errno);
        } else {
            return $conn;
        }
    }
}

// Function to update user profile information
if (!function_exists('update_profile')) {
    function update_profile($conn, $user_id, $firstname, $lastname, $username, $email, $anrede) {
        $sql = "UPDATE `user` SET firstname = ?, lastname = ?, username = ?, email = ?, anrede = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param('sssssi', $firstname, $lastname, $username, $email, $anrede, $user_id);
        if ($stmt->execute()) {
            return $stmt->affected_rows > 0 ? "Profile updated successfully." : "No changes made.";
        } else {
            return "Failed to update profile: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

// Function to update user password
if (!function_exists('update_password')) {
    function update_password($conn, $user_id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE `user` SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param('si', $hashed_password, $user_id);
        if ($stmt->execute()) {
            return $stmt->affected_rows > 0 ? "Password updated successfully." : "No changes made.";
        } else {
            return "Failed to update password: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

// Function to add a product to the products table
if (!function_exists('add_product')) {
    function add_product($conn, $id, $name, $price, $image, $description, $typeName, $category) {
        $sql = "INSERT INTO produkte (itemId, itemName, itemPrice, itemImage, itemDescription, typeName, category) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdssss", $id, $name, $price, $image, $description, $typeName, $category);
        if (!$stmt->execute()) {
            return "Error: " . $stmt->error;
        }
        return "Product added.";
    }
}

// Function to get products from the products table with optional filter
if (!function_exists('get_products')) {
    function get_products($conn, $filter = '', $offset = 0, $limit = 6) {
        $sql = "SELECT * FROM produkte";
        if ($filter) {
            $sql .= " WHERE typeName = ? AND category = 'regular'";
        } else {
            $sql .= " WHERE category != 'brand'";
        }
        $sql .= " LIMIT ?, ?";
        $stmt = $conn->prepare($sql);
        if ($filter) {
            $stmt->bind_param("sii", $filter, $offset, $limit);
        } else {
            $stmt->bind_param("ii", $offset, $limit);
        }
        if (!$stmt->execute()) {
            return "Error: " . $stmt->error;
        }
        return $stmt->get_result();
    }
}

// Function to add an item to the cart
if (!function_exists('add_to_cart')) {
    function add_to_cart($conn, $item_id, $user_id, $quantity) {
        $sql = "INSERT INTO basket (id, user_id, name, price, image, quantity, size, category) VALUES (?, ?, 'Sample Name', 10.00, 'sample_image.jpg', ?, 'M', 'sample_category')";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param("iii", $item_id, $user_id, $quantity);
        if (!$stmt->execute()) {
            return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        return "Item added to basket.";
    }
}

// Function to checkout and create a purchased record
if (!function_exists('checkout')) {
    function checkout($conn, $user_id) {
        $conn->begin_transaction();

        try {
            $cart_query = $conn->query("SELECT * FROM basket WHERE user_id='$user_id'");

            if (!$cart_query) {
                throw new Exception('Failed to retrieve basket items.');
            }

            while ($fetch_cart = $cart_query->fetch_assoc()) {
                $item_user_id = $fetch_cart['user_id'];
                $item_name = $fetch_cart['name'];
                $item_price = $fetch_cart['price'];
                $item_image = $fetch_cart['image'];
                $item_size = $fetch_cart['size'];
                $item_category = $fetch_cart['category'];
                $purchase_date = date('Y-m-d H:i:s');
                $tracking_code = '';

                $insert_query = "INSERT INTO purchased (user_id, name, price, image, size, category, purchase_date, tracking_code)
                                VALUES ('$item_user_id', '$item_name', '$item_price', '$item_image', '$item_size', '$item_category', '$purchase_date', '$tracking_code')";
                if (!$conn->query($insert_query)) {
                    throw new Exception('Failed to insert item into purchased table.');
                }
            }

            $delete_query = "DELETE FROM basket WHERE user_id='$user_id'";
            if (!$conn->query($delete_query)) {
                throw new Exception('Failed to delete items from basket.');
            }

            $conn->commit();
            return "Checkout successful.";
        } catch (Exception $e) {
            $conn->rollback();
            return "Checkout failed: " . $e->getMessage();
        }
    }
}

// Function to add an item to the basket
if (!function_exists('add_basket_card')) {
    function add_basket_card($conn, $item_id, $quantity, $user_id) {
        $sql = "INSERT INTO basket (id, user_id, name, price, image, quantity, size, category) VALUES (?, ?, 'Sample Name', 10.00, 'sample_image.jpg', ?, 'M', 'sample_category')";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param("iii", $item_id, $user_id, $quantity);
        if ($stmt->execute()) {
            return "Item added to basket.";
        } else {
            return "Failed to add item: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

// Function to delete an item from the basket
if (!function_exists('delete_cart')) {
    function delete_cart($conn, $item_id, $user_id) {
        $sql = "DELETE FROM basket WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param("ii", $item_id, $user_id);
        if ($stmt->execute()) {
            return "Item removed from basket.";
        } else {
            return "Failed to remove item: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

// Function to update the size of an item in the basket
if (!function_exists('update_size')) {
    function update_size($conn, $item_id, $new_size, $user_id) {
        $sql = "UPDATE basket SET size = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param("sii", $new_size, $item_id, $user_id);
        if ($stmt->execute()) {
            return "Size updated successfully.";
        } else {
            return "Failed to update size: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

// Function to update the quantity of an item in the basket
if (!function_exists('update_quantity')) {
    function update_quantity($conn, $item_id, $quantity, $user_id) {
        $sql = "UPDATE basket SET quantity = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $stmt->bind_param("iii", $quantity, $item_id, $user_id);
        if ($stmt->execute()) {
            return "Quantity updated successfully.";
        } else {
            return "Failed to update quantity: (" . $stmt->errno . ") " . $stmt->error;
        }
    }
}

?>
