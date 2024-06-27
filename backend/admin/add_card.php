<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="CSS/uploaderCards.css" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>

<?php
// Include database connection file
include "../../config/conn.php";
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Execute a query to select all columns from the user table
$query = "SELECT * FROM user";
$result = mysqli_query($conn, $query);
$totalUsers = mysqli_num_rows($result);

// Execute a query to select all columns from the products table
$queryProducts = "SELECT * FROM produkte";
$resultProducts = mysqli_query($conn, $queryProducts);
$totalProducts = mysqli_num_rows($resultProducts);
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

        <?php 
        // Display error message if any
        if (isset($_GET['error'])) : ?>
            <p><?php echo $_GET['error']; ?></p>
        <?php endif ?>

        <div class="container-fluid">
            <div class="wrapper" style="height: 710px; border: solid gray 1px;">
                <header>File Uploader</header>
                <!-- File Upload Form -->
                <form method="POST" action='uploadfile.php' enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Type</label>
                        <select class="form-control" required="required" name="typeName">
                            <option value="">Select an option</option>
                            <option value="bag">Bag</option>
                            <option value="sneakers">Sneakers</option>
                            <option value="cloth">Cloth</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" size="200" class="form-control" name="itemName" required />
                    </div>
                    <div class="form-group">
                        <label>Product Price</label>
                        <input type="text" size="200" class="form-control" name="itemPrice" required />
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <input type="text" size="200" class="form-control" name="itemDescription" required />
                    </div>
                    <div class="form-group">
                        <label>Product Category</label>
                        <select class="form-control" required="required" name="category">
                            <option value="brand">Brand</option>
                            <option value="regular">Regular</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- File Input for Product Image -->
                        <div class="fileadd">
                            <input class="file-input" required="required" type="file" name="itemImage" hidden>
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Browse File to Upload</p>
                        </div>
                    </div>
                    <br /> 
                    <div class="form-group">
                        <button name="add_card" class="btn btn-info form-control">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php 
    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- Custom JavaScript for admin panel and upload functionality -->
    <script src="JS/admin.js"></script>
    <script src="JS/upload.js"></script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
      $('.status-btn').click(function() {
        var userId = $(this).data('id');
        
        // Send an AJAX request to the server to change the user's status
        $.ajax({
          url: 'change_status.php',
          method: 'POST',
          data: { id: userId },
          success: function(response) {
            // Handle the server's successful response
            if (response === 'success') {
              alert('User status successfully changed.');
              location.reload(); // Reload the page to update the data
            } else {
              alert('Error changing user status.');
            }
            window.location.reload();
          },
          error: function() {
            alert('An error occurred while sending the request to the server.');
          }
        });
      });
    });
    </script>
</body>
</html>
