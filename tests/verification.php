<?php

if (!function_exists('validate')) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

function register_user($conn, $postData)
{
    $errors = [];

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

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(anrede, firstname, lastname, email, password, username) VALUES (?, ?, ?, ?, ?, ?)";
        $insert = $conn->prepare($sql);
        $insert->bind_param("ssssss", $anrede, $firstname, $lastname, $email, $hashedPassword, $username);
        if ($insert->execute()) {
            $result = "Registration successful";
        } else {
            $result = "Error during registration";
        }
        $insert->close();
    } else {
        $result = implode("\n", $errors);
    }

    return $result;
}

// For browser testing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../config/conn.php');
    echo register_user($conn, $_POST);
}
