<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
include "../../config/conn.php";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user details from the database
$sql = "SELECT * FROM `user` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $anrede = $_POST['anrede'];

    $sql = "UPDATE `user` SET firstname = ?, lastname = ?, username = ?, email = ?, anrede = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $firstname, $lastname, $username, $email, $anrede, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Profile updated successfully.";
    } else {
        echo "No changes made.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="path/to/your/css/style.css"> <!-- Add your CSS file path here -->
    <style>
        /* Profile Page CSS */
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }

        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .profile-header img {
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .profile-header p {
            margin: 5px 0 0;
            color: #777;
        }

        .profile-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .profile-info div {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .profile-info p {
            margin: 0;
            color: #333;
        }

        .profile-actions {
            margin-top: 20px;
            text-align: center;
        }

        .profile-actions a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <h1>Edit Profile</h1>
        <form action="edit_profile.php" method="POST">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="anrede">Title:</label>
                <input type="text" id="anrede" name="anrede" value="<?php echo htmlspecialchars($user['anrede']); ?>" required>
            </div>
            <button type="submit">Update Profile</button>
        </form>
        <div class="profile-actions">
            <a href="profile.php">Back to Profile</a>
        </div>
    </div>
</body>
</html>
