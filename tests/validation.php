<?php
ob_start();  // Start output buffering

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!function_exists('validate')) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

function login_user($conn)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = validate($_POST['username']);
            $password = validate($_POST['password']);

            $sql = "SELECT id, username, password, role, status FROM user WHERE username = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                if (password_verify($password, $row["password"])) {
                    if ($row["status"] == "Inactive") {
                        return "You are no longer allowed to access this site";
                    } else {
                        $_SESSION["username"] = $row['username'];
                        $_SESSION["role"] = $row["role"];
                        $_SESSION["status"] = $row['status'];
                        $_SESSION["id"] = $row['id'];

                        return "Login successful.";
                    }
                } else {
                    return "Invalid data for user! Try again";
                }
            } else {
                return "Invalid data for user! Try again";
            }
        }
    }
}

ob_end_flush();  // Flush the output buffer

if (!debug_backtrace()) {
    // If not included, assume this is the entry point and execute the login process
    include_once __DIR__ . "/../config/conn.php";
    echo login_user($conn);
}
