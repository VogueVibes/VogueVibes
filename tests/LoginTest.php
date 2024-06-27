<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $server = "127.0.0.1";
        $db = "software_db";
        $user = "root";
        $pwd = "";
        $port = 3306;
        $socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";

        $this->conn = new mysqli($server, $user, $pwd, $db, $port, $socket);

        // Check connection
        if ($this->conn->connect_error) {
            $this->fail("Connection failed: " . $this->conn->connect_error);
        }

        // Disable foreign key checks
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");

        // Clear the user table before each test
        $this->conn->query("DELETE FROM user");

        // Enable foreign key checks
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 1");

        // Ensure the correct path to login.php
        require_once('validation.php');
    }

    protected function tearDown(): void
    {
        // Close the database connection
        $this->conn->close();
    }

    public function testSuccessfulLogin()
    {
        // Create a test user
        $passwordHash = password_hash("validPassword", PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO user (username, password, role, status) VALUES ('validUser', '$passwordHash', 0, 'Active')");

        // Login request with valid credentials
        $_POST['username'] = 'validUser';
        $_POST['password'] = 'validPassword';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        $output = login_user($this->conn);
        ob_end_clean();

        // Check successful login
        $this->assertStringContainsString('Login successful.', $output);
    }

    public function testLoginWithInvalidPassword()
    {
        // Create a test user
        $passwordHash = password_hash("validPassword", PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO user (username, password, role, status) VALUES ('validUser', '$passwordHash', 0, 'Active')");

        // Login request with an incorrect password
        $_POST['username'] = 'validUser';
        $_POST['password'] = 'invalidPassword';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        $output = login_user($this->conn);
        ob_end_clean();

        // Check login error
        $this->assertStringContainsString('Invalid data for user! Try again', $output);
    }

    public function testLoginWithInactiveUser()
    {
        // Create a test user
        $passwordHash = password_hash("validPassword", PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO user (username, password, role, status) VALUES ('inactiveUser', '$passwordHash', 0, 'Inactive')");

        // Login request for an inactive user
        $_POST['username'] = 'inactiveUser';
        $_POST['password'] = 'validPassword';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        $output = login_user($this->conn);
        ob_end_clean();

        // Check login error
        $this->assertStringContainsString('You are no longer allowed to access this site', $output);
    }
}

// vendor/bin/phpunit tests/LoginTest.php