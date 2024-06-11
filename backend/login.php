<?php
ob_start();  // Start output buffering

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "login.php script is running.<br>";  // Debugging output

session_start();
echo "Session started.<br>";

include "../components/header.php";
echo "Header included.<br>";
include "../components/navbar.php";
echo "Navbar included.<br>";

$errordata = "";

echo "Reached POST check.<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Inside POST check.<br>";
    if (isset($_POST['username']) && isset($_POST['password'])) {
        echo "Username and Password are set.<br>";

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        include_once __DIR__ . "/../config/conn.php";  // Corrected path
        echo "Database connection file included.<br>";
        global $conn;

        if ($conn) {
            echo "Database connection established.<br>";
        } else {
            echo "Database connection failed.<br>";
        }

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";

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

        if ($result->num_rows > 0) {
            if (password_verify($password, $row["password"]) && $row["status"] == "Inactive") {
                echo "User is inactive.<br>";
                header("Location: login.php?error=You are no longer allowed to access this site");
                exit();
            } else {
                if (password_verify($password, $row["password"])) {
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["role"] = $row["role"];
                    $_SESSION["status"] = $row['status'];
                    $_SESSION["id"] = $row['id'];

                    echo "SESSION (after setting): ";
                    var_dump($_SESSION);

                    echo "Success: Redirecting to index.php<br>";
                    header("Location: index.php");
                    exit();
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
} else {
    echo "Request method is not POST.<br>";
}

ob_end_flush();  // Flush the output buffer
?>
