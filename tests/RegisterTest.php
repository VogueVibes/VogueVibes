<?php

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $server = "127.0.0.1";
        $db = "itprojeckt";
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

        // Ensure the correct path to register.php
        require_once('verification.php');
    }

    protected function tearDown(): void
    {
        // Close the database connection
        $this->conn->close();
    }

    public function testSuccessfulRegistration()
    {
        // Data for successful registration
        $postData = [
            'anrede' => 'Mr',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'strongpassword',
            'pwdconfirm' => 'strongpassword',
            'username' => 'johndoe'
        ];

        ob_start();
        $output = register_user($this->conn, $postData);
        ob_end_clean();

        // Check successful registration
        $this->assertStringContainsString('Registration successful', $output);

        // Check that the user was added to the database
        $result = $this->conn->query("SELECT * FROM user WHERE email = 'johndoe@example.com'");
        $this->assertEquals(1, $result->num_rows);
    }

    public function testRegistrationWithMismatchedPasswords()
    {
        // Data with mismatched passwords
        $postData = [
            'anrede' => 'Mr',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'strongpassword',
            'pwdconfirm' => 'wrongpassword',
            'username' => 'johndoe'
        ];

        ob_start();
        $output = register_user($this->conn, $postData);
        ob_end_clean();

        // Check error for mismatched passwords
        $this->assertStringContainsString('Passwords do not match!', $output);
    }

    public function testRegistrationWithShortPassword()
    {
        // Data with short password
        $postData = [
            'anrede' => 'Mr',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'short',
            'pwdconfirm' => 'short',
            'username' => 'johndoe'
        ];

        ob_start();
        $output = register_user($this->conn, $postData);
        ob_end_clean();

        // Check error for short password
        $this->assertStringContainsString('Password is too short, please enter at least 8 characters!', $output);
    }

    public function testRegistrationWithExistingEmail()
    {
        // Create a user with an existing email
        $passwordHash = password_hash("strongpassword", PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO user (anrede, firstname, lastname, email, password, username) VALUES ('Mr', 'John', 'Doe', 'johndoe@example.com', '$passwordHash', 'johndoe')");

        // Attempt registration with the same email
        $postData = [
            'anrede' => 'Mr',
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'strongpassword',
            'pwdconfirm' => 'strongpassword',
            'username' => 'janedoe'
        ];

        ob_start();
        $output = register_user($this->conn, $postData);
        ob_end_clean();

        // Check error for existing email
        $this->assertStringContainsString('Email is already in use!', $output);
    }

    public function testRegistrationWithExistingUsername()
    {
        // Create a user with an existing username
        $passwordHash = password_hash("strongpassword", PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO user (anrede, firstname, lastname, email, password, username) VALUES ('Mr', 'John', 'Doe', 'johndoe@example.com', '$passwordHash', 'johndoe')");

        // Attempt registration with the same username
        $postData = [
            'anrede' => 'Mr',
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'janedoe@example.com',
            'password' => 'strongpassword',
            'pwdconfirm' => 'strongpassword',
            'username' => 'johndoe'
        ];

        ob_start();
        $output = register_user($this->conn, $postData);
        ob_end_clean();

        // Check error for existing username
        $this->assertStringContainsString('Username is already in use!', $output);
    }
}
// vendor/bin/phpunit tests/RegisterTest.php