<?php
function register_user($postData)
{
    $errors = [];

    // Include the database connection
    require_once('../../config/conn.php');

    // Extract form data
    $anrede = $postData["anrede"];
    $firstname = $postData["firstname"];
    $lastname = $postData["lastname"];
    $email = $postData["email"];
    $password = $postData["password"];
    $confirmPassword = $postData["pwdconfirm"];
    $username = $postData["username"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $errors['password'] = "Passwords do not match!";
    }

    // Check if password is at least 8 characters long
    if (strlen($password) < 8) {
        $errors['password'] = "Password is too short, please enter at least 8 characters!";
    }

    // If no errors so far, proceed to check database for existing email and username
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

    // If still no errors, proceed to insert the new user into the database
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL insert statement
        $sql = "INSERT INTO user(anrede, firstname, lastname, email, password, username) VALUES (?, ?, ?, ?, ?, ?)";
        $insert = $conn->prepare($sql);
        $insert->bind_param("ssssss", $anrede, $firstname, $lastname, $email, $hashedPassword, $username);
        
        // Execute the statement and check for success
        if ($insert->execute()) {
            // Close the connection before redirecting
            $insert->close();
            $conn->close();
            // Redirect to login.php after successful registration
            header("Location: login.php");
            exit();
        } else {
            $result = "Error during registration";
        }
        $insert->close();
    } else {
        $result = implode("\n", $errors);
    }

    // Close the database connection
    $conn->close();
    return $result;
}

// For testing in the browser
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo register_user($_POST);
}
?>
