<?php

use PHPUnit\Framework\TestCase;

require_once 'functions.php';

class FunctionalTests extends TestCase
{
    private $conn;
    private $server = "localhost";
    private $user = "root";
    private $pwd = "";
    private $db = "software_db";
    private $port = 3306;
    private $socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";

    protected function setUp(): void
    {
        $this->conn = new mysqli($this->server, $this->user, $this->pwd, $this->db, $this->port, $this->socket);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->conn->query("DELETE FROM produkte");
        $this->conn->query("DELETE FROM basket");
        $this->conn->query("DELETE FROM purchased");
        $this->conn->query("DELETE FROM user");
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 1");

        $this->conn->query("INSERT INTO user (id, firstname, lastname, username, email, anrede, password, role, status) VALUES (1, 'Test', 'User', 'testuser', 'test@example.com', 'Mr', 'password', 0, 'Active')");
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    // DBConnection Tests
    public function testSuccessfulConnection()
    {
        $conn = check_db_connection($this->server, $this->user, $this->pwd, $this->db, $this->port, $this->socket);
        $this->assertInstanceOf(mysqli::class, $conn);
        $conn->close();
    }

    public function testFailedConnection()
    {
        $this->expectException(mysqli_sql_exception::class);
        check_db_connection($this->server, "wrong_user", "wrong_password", "nonexistent_db", $this->port, $this->socket);
    }

    // Profile Tests
    public function testUpdateProfile()
    {
        $result = update_profile($this->conn, 1, 'NewFirstName', 'NewLastName', 'newusername', 'newemail@example.com', 'Mr');
        $this->assertStringContainsString('Profile updated successfully.', $result);

        $query = $this->conn->query("SELECT * FROM user WHERE id = 1");
        $user = $query->fetch_assoc();
        $this->assertEquals('NewFirstName', $user['firstname']);
        $this->assertEquals('NewLastName', $user['lastname']);
        $this->assertEquals('newusername', $user['username']);
        $this->assertEquals('newemail@example.com', $user['email']);
    }

    public function testUpdatePassword()
    {
        $result = update_password($this->conn, 1, 'newpassword');
        $this->assertStringContainsString('Password updated successfully.', $result);

        $query = $this->conn->query("SELECT * FROM user WHERE id = 1");
        $user = $query->fetch_assoc();
        $this->assertTrue(password_verify('newpassword', $user['password']));
    }

    // Basket Tests
    public function testRemoveFromBasket()
    {
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_to_cart($this->conn, 1, 1, 1);
        $this->conn->query("DELETE FROM basket WHERE id = 1 AND user_id = 1");
        $query = $this->conn->query("SELECT * FROM basket WHERE user_id = 1");
        $this->assertEquals(0, $query->num_rows);
    }


    public function testLoadFilteredProducts()
    {
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_product($this->conn, 2, 'Test Product 2', 20.00, 'test_image_2.jpg', 'Description 2', 'test_type', 'brand');

        $result = get_products($this->conn, 'test_type');
        $this->assertEquals(1, $result->num_rows);
    }

    public function testLoadMoreProducts()
    {
        for ($i = 1; $i <= 10; $i++) {
            add_product($this->conn, $i, "Test Product $i", 10.00, "test_image_$i.jpg", "Description $i", 'test_type', 'regular');
        }

        $result = get_products($this->conn, '', 6);
        $this->assertEquals(4, $result->num_rows);
    }

    // Checkout Tests
    public function testSuccessfulCheckout()
    {
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_to_cart($this->conn, 1, 1, 1);
        
        $output = checkout($this->conn, 1);
        $this->assertStringContainsString('Checkout successful.', $output);

        $query = $this->conn->query("SELECT * FROM purchased WHERE user_id = 1");
        $this->assertEquals(1, $query->num_rows);
    }


    public function testCheckout()
    {
        // Add item to basket
        $this->conn->query("INSERT INTO basket (id, user_id, name, price, image, size, category, quantity) VALUES (1, 1, 'Test Item', 10.00, 'test.jpg', 'M', 'test', 1)");

        // Perform checkout
        $_SESSION['id'] = 1;
        $_SERVER['REQUEST_METHOD'] = 'POST';

        ob_start();
        $output = checkout($this->conn, $_SESSION['id']);
        ob_end_clean();

        // Check successful checkout
        $this->assertStringContainsString('Checkout successful.', $output);

        // Verify that the basket is empty
        $result = $this->conn->query("SELECT * FROM basket WHERE user_id = 1");
        $this->assertEquals(0, $result->num_rows);

        // Verify that the purchased table has the item
        $result = $this->conn->query("SELECT * FROM purchased WHERE user_id = 1");
        $this->assertEquals(1, $result->num_rows);
    }
    // Complex Tests
    public function testAddRemoveUpdateMultipleItems()
    {
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_product($this->conn, 2, 'Test Product 2', 20.00, 'test_image_2.jpg', 'Description 2', 'test_type', 'regular');

        add_to_cart($this->conn, 1, 1, 1);
        add_to_cart($this->conn, 2, 1, 1);

        update_profile($this->conn, 1, 'UpdatedFirstName', 'UpdatedLastName', 'updatedusername', 'updatedemail@example.com', 'Mr');

        $this->conn->query("DELETE FROM basket WHERE id = 2 AND user_id = 1");
        $query = $this->conn->query("SELECT * FROM basket WHERE user_id = 1");
        $this->assertEquals(1, $query->num_rows);
    }

    // Test loading all products from the database
    public function testLoadAllProducts()
    {
        // Add test products to the database
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_product($this->conn, 2, 'Test Product 2', 20.00, 'test_image_2.jpg', 'Description 2', 'test_type', 'regular');

        // Get all products from the database
        $result = get_products($this->conn);
        $this->assertEquals(2, $result->num_rows);
    }


    // Test adding an item to the cart
    public function testAddToCart()
    {
        // Add a test product to the database
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');

        // Add the product to the cart
        $result = add_to_cart($this->conn, 1, 1, 1);
        $this->assertStringContainsString('Item added to basket.', $result);

        // Check if the item was added to the basket
        $query = $this->conn->query("SELECT * FROM basket WHERE id = 1 AND user_id = 1");
        $this->assertEquals(1, $query->num_rows);
    }


    // Test successful database connection
    public function testSuccessfulDBConnection()
    {
        // Check if the database connection is successful
        $conn = check_db_connection("localhost", "root", "", "itprojeckt", 3306, "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock");
        $this->assertInstanceOf(mysqli::class, $conn);
        $conn->close();
    }

    // Test failed database connection
    public function testFailedDBConnection()
    {
        // Expect an exception for a failed database connection
        $this->expectException(mysqli_sql_exception::class);
        check_db_connection("localhost", "wrong_user", "wrong_password", "itprojeckt", 3306, "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock");
    }

    // Test adding an item to the basket
    public function testAddToBasket()
    {
        $output = add_basket_card($this->conn, 1, 1, 1);
        $this->assertStringContainsString('Item added to basket.', $output);
    }
 
    // Test changing the size of an item in the basket
    public function testChangeSizeInBasket()
    {
        $output = update_size($this->conn, 1, 'L', 1);
        $this->assertStringContainsString('Size updated successfully.', $output);
    }

    // Test adding multiple items to the basket
    public function testAddMultipleItemsToBasket()
    {
        $output1 = add_basket_card($this->conn, 1, 1, 1);
        $this->assertStringContainsString('Item added to basket.', $output1);

        $output2 = add_basket_card($this->conn, 2, 2, 1);
        $this->assertStringContainsString('Item added to basket.', $output2);
    }

    // Test changing the quantity of an item in the basket
    public function testChangeQuantity()
    {
        $output1 = add_basket_card($this->conn, 1, 1, 1);
        $this->assertStringContainsString('Item added to basket.', $output1);

        // Update the quantity to 5
        $output2 = update_quantity($this->conn, 1, 5, 1);
        $this->assertStringContainsString('Quantity updated successfully.', $output2);
    }

    // Test the basket is empty after removing an item
    public function testEmptyBasketAfterRemoval()
    {
        $output1 = add_basket_card($this->conn, 1, 1, 1);
        $this->assertStringContainsString('Item added to basket.', $output1);

        $output2 = delete_cart($this->conn, 1, 1);
        $this->assertStringContainsString('Item removed from basket.', $output2);

        // Check if the basket is empty
        $result = $this->conn->query("SELECT * FROM basket WHERE user_id = 1");
        $this->assertEquals(0, $result->num_rows);
    }
    public function testRemoveAllItemsFromBasket()
{
    add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
    add_to_cart($this->conn, 1, 1, 1);
    add_to_cart($this->conn, 2, 1, 1);

    $this->conn->query("DELETE FROM basket WHERE user_id = 1");
    $result = $this->conn->query("SELECT * FROM basket WHERE user_id = 1");
    $this->assertEquals(0, $result->num_rows);
}
public function testGetProductsByPriceRange()
{
    add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
    add_product($this->conn, 2, 'Test Product 2', 20.00, 'test_image_2.jpg', 'Description 2', 'test_type', 'regular');
    add_product($this->conn, 3, 'Test Product 3', 30.00, 'test_image_3.jpg', 'Description 3', 'test_type', 'regular');

    $result = $this->conn->query("SELECT * FROM produkte WHERE itemPrice BETWEEN 15 AND 25");
    $this->assertEquals(1, $result->num_rows);
}

   // Test checking the quantity of items in the basket
    public function testCheckQuantityInBasket()
    {
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_to_cart($this->conn, 1, 1, 2);
        add_to_cart($this->conn, 2, 1, 3);

        $result = $this->conn->query("SELECT SUM(quantity) as total_quantity FROM basket WHERE user_id = 1");
        $this->assertEquals(5, $result->fetch_assoc()['total_quantity']);
    }
    public function testUpdateAllSizesInBasket()
    {
        add_product($this->conn, 1, 'Test Product 1', 10.00, 'test_image_1.jpg', 'Description 1', 'test_type', 'regular');
        add_to_cart($this->conn, 1, 1, 1);
        add_to_cart($this->conn, 2, 1, 1);
    
        $this->conn->query("UPDATE basket SET size = 'L' WHERE user_id = 1");
        $result = $this->conn->query("SELECT DISTINCT size FROM basket WHERE user_id = 1");
        $this->assertEquals(1, $result->num_rows);
        $this->assertEquals('L', $result->fetch_assoc()['size']);
    }
}

?>
<!-- vendor/bin/phpunit tests/FunctionalTests.php  -->