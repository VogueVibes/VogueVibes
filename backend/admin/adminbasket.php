<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include "../../config/conn.php";
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Execute a query to select all columns from the basket table
$query = "SELECT * FROM basket";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query execution error: ' . mysqli_error($conn));
}
$totalUsers = mysqli_num_rows($result); // Get the total number of users
$totalSum = 0;

// Calculate the total sum of all items in the basket
while ($row = mysqli_fetch_assoc($result)) {
    $itemPrice = $row['price'];
    $quantity = $row['quantity'];
    $subtotal = $itemPrice * $quantity;
    $totalSum += $subtotal;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Custom CSS for admin panel -->
    <link rel="stylesheet" href="CSS/admin.css">
     
    <!-- Iconscout CSS for icons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard Panel</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!-- Logo Image -->
                <img src="../../frontend/img/workpieces/newlogo.png" alt="">
            </div>
            <span class="logo_name">VogueVibes</span>
        </div>
        <div class="menu-items">
            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="add_card.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li>
                <li><a href="adminbasket.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
            </ul>
            
            <!-- Logout and Dark Mode Toggle -->
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>
                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-shopping-bag"></i>
                        <span class="text">Total Products</span>
                        <span class="number"><?php echo $totalUsers; ?></span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-bill"></i>
                        <span class="text">Total Amount</span>
                        <span class="number"><?php echo $totalSum;?>$</span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-shopping-bag"></i>
                        <span class="text">Total Orders</span>
                        <span class="number">10,120</span>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Activity</span>
                </div>
                <div class="activity-data">
                    <div class="data id">
                        <span class="data-title">ID</span>
                        <?php 
                        // Reset the result pointer to the beginning
                        mysqli_data_seek($result, 0);
                        
                        // Output data in HTML
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['id'] . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <div class="data names">
                        <span class="data-title">Name</span>
                        <?php 
                        // Reset the result pointer to the beginning
                        mysqli_data_seek($result, 0);
                        
                        // Output data in HTML
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['name'] . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <div class="data email">
                        <span class="data-title">Price</span>
                        <?php 
                        // Reset the result pointer to the beginning
                        mysqli_data_seek($result, 0);
                        
                        // Output data in HTML
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['price'] . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <div class="data type">
                        <span class="data-title">Size</span>
                        <?php 
                        // Reset the result pointer to the beginning
                        mysqli_data_seek($result, 0);
                        
                        // Output data in HTML
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['size'] . '</span>';
                            }
                        }
                        ?>
                    </div> 
                    <div class="data type">
                        <span class="data-title">Quantity</span>
                        <?php 
                        // Reset the result pointer to the beginning
                        mysqli_data_seek($result, 0);
                        
                        // Output data in HTML
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['quantity'] . '</span>';
                            }
                        }
                        ?>
                    </div> 
                    <div class="data status">
                        <span class="data-title">Editing</span>
                        <?php 
                        // Reset the result pointer to the beginning
                        mysqli_data_seek($result, 0);
                        
                        // Output data in HTML
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="data-list">';
                                echo '<span>' . $row['category'] . '</span>';
                                echo '<button class="status-btn" data-id="' . $row['id'] . '">Change</button>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php 
    // Close the database connection
    mysqli_close($conn);
    ?>
    <!-- Custom JavaScript for admin panel functionality -->
    <script src="JS/admin.js"></script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
