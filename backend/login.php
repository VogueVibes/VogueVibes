<?php
ob_start();  // Start output buffering

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();  // Start the session

// Include header and navbar components
include "../components/header.php";
include "../components/navbar.php";

$errordata = "";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Inside POST check.<br>";
    // Check if username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        echo "Username and Password are set.<br>";

        // Function to validate form data
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Include database connection file
        include_once __DIR__ . "/../config/conn.php";
        echo "Database connection file included.<br>";
        global $conn;

        // Check if the database connection is established
        if ($conn) {
            echo "Database connection established.<br>";
        } else {
            echo "Database connection failed.<br>";
        }

        // Validate username and password
        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";

        // Prepare SQL query to fetch user data
        $sql = "SELECT id, username, password, role, status FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "Result: ";
        var_dump($row);

        // Check if any user was found
        if ($result->num_rows > 0) {
            // Check if the password is correct and the user is inactive
            if (password_verify($password, $row["password"]) && $row["status"] == "Inactive") {
                echo "User is inactive.<br>";
                header("Location: login.php?error=You are no longer allowed to access this site");
                exit();
            } else {
                // Check if the password is correct
                if (password_verify($password, $row["password"])) {
                    // Set session variables
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["role"] = $row["role"];
                    $_SESSION["status"] = $row['status'];
                    $_SESSION["id"] = $row['id'];

                    echo "SESSION (after setting): ";
                    var_dump($_SESSION);

                    // Redirect based on user role
                    if ($_SESSION["role"] == 1) {
                        echo "User is admin: Redirecting to admin panel<br>";
                        header("Location: ../../backend/admin/admin.php");
                        exit();
                    } else {
                        echo "Success: Redirecting to index.php<br>";
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    echo "Password verification failed.<br>";
                    header("Location: login.php?error=Invalid data for user! Try again");
                    exit();
                }
            }
        } else {
            echo "No user found.<br>";
            header("Location: login.php?error=Invalid data for user! Try again");
            exit();
        }
    } else {
        echo "Username or Password not set.<br>";
    }
}

ob_end_flush();  // Flush the output buffer
?>
