<?php

// Check if the function validate already exists to avoid redeclaration
if (!function_exists('validate')) {
    function validate($data)
    {
        // Trim, strip slashes, and convert special characters to HTML entities
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

// Function to register a user
function register_user($conn, $postData)
{
    // Array to store errors
    $errors = [];

    // Validate and sanitize user input
    $anrede = validate($postData["anrede"]);
    $firstname = validate($postData["firstname"]);
    $lastname = validate($postData["lastname"]);
    $email = validate($postData["email"]);
    $password = validate($postData["password"]);
    $confirmPassword = validate($postData["pwdconfirm"]);
    $username = validate($postData["username"]);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $errors['password'] = "Passwords do not match!";
    }

    // Check if password is at least 8 characters long
    if (strlen($password) < 8) {
        $errors['password'] = "Password is too short, please enter at least 8 characters!";
    }

    // Proceed if there are no errors
    if (empty($errors)) {
        // Check if email is already in use
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['email'] = "Email is already in use!";
        }
        $stmt->close();

        // Check if username is already in use
        $stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['username'] = "Username is already in use!";
        }
        $stmt->close();
    }

    // Proceed if there are still no errors
    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query to insert user data
        $sql = "INSERT INTO user(anrede, firstname, lastname, email, password, username) VALUES (?, ?, ?, ?, ?, ?)";
        $insert = $conn->prepare($sql);
        $insert->bind_param("ssssss", $anrede, $firstname, $lastname, $email, $hashedPassword, $username);
        if ($insert->execute()) {
            // Successful registration
            $result = "Registration successful";
        } else {
            // Error during registration
            $result = "Error during registration";
        }
        $insert->close();
    } else {
        // Join errors into a single string
        $result = implode("\n", $errors);
    }

    // Return result
    return $result;
}

// For browser testing - handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    require_once('../config/conn.php');
    // Register user and echo the result
    echo register_user($conn, $_POST);
}
