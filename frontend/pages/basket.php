<?php
session_start();
include "../components/header.php"; // Include the header component
include "../components/navbar.php"; // Include the navbar component
@include "../../config/conn.php"; // Include the database connection
@include "../../backend/add_basket_card.php"; // Include the script to add items to the basket
@include "../../backend/delete_cart.php"; // Include the script to delete items from the cart
@include "../../backend/decrement.php"; // Include the script to decrement item quantity

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to determine the image path based on the item category
function getImagePath($item) {
    $baseDir = '../img/';
    $brandDir = 'exclusive/';
    $regularDir = 'catalogue/';

    if ($item['category'] === 'brand') {
        $path = $baseDir . $brandDir . $item['image'];
    } else {
        $path = $baseDir . $regularDir . $item['image'];
    }

    // Return the correct path or a default image if the file does not exist
    if (file_exists($path)) {
        return $path;
    } else {
        return $baseDir . 'default.png';
    }
}

// Fetch user's cart items
$cart_query = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='{$_SESSION['id']}'") or die('Query failed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }

        .basket-page {
            background: #ddc8bf;
        }

        .products {
            margin-top: 5%;
            display: grid;
            grid-template-columns: 60% 40%;
            gap: 20px;
        }

        .grund {
            display: grid;
            grid-column: 1;
        }

        .abzac {
            margin-bottom: 40px;
            margin-left: 3%;
        }

        .card-container {
            display: flex;
            flex-direction: column;
            margin-left: 40px;
            flex-direction: row;
            margin-bottom: 20px;
        }

        .cart-wrapper {
            display: flex;
            flex-direction: row;
        }

        .card-info {
            font-size: 18px;
        }

        .sumBlock {
            height: auto;
            color: white;
            margin-right: 150px;
        }

        .total-container {
            display: flex;
            flex-direction: column;
            position: sticky;
            border: solid 3px white;
            top: 100px;
            padding: 20px;
            align-items: stretch;
        }

        .grund-item {
            font-weight: 900;
            font-size: 30px;
            margin-bottom: 30px;
        }

        .total-item {
            margin-bottom: 15px;
        }

        .promo {
            margin-top: 80px;
        }

        .line {
            border: none;
            border-top: 1px solid white;
            margin: 10px 0;
            width: 100%;
        }

        .ende-item {
            margin-top: 20px;
            font-size: 20px;
            font-weight: 900;
        }

        .image-container {
            flex: 1;
            bottom: 0;
            left: 0;
            background: white;
            height: 300px;
            width: 90%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .info-container {
            flex: 2;
            padding-left: 20px;
        }

        .info-container h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .info-container p {
            font-size: 20px;
        }

        .remove-btn {
            margin-top: 20px;
            font-size: 15px;
            padding: 5px;
            color: #fff;
            background-color: #d9534f;
            border-color: #d43f3a;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .products {
                display: block;
            }

            .sumBlock {
                margin-right: 0;
                margin-top: 20px;
            }

            .card-container {
                margin-left: 0;
                flex-direction: column;
                align-items: center;
            }

            .image-container {
                width: 100%;
                height: auto;
            }

            .info-container {
                padding-left: 0;
                text-align: center;
            }

            .total-container {
                position: relative;
                top: auto;
                border: none;
                background: none;
            }
        }

        @media (max-width: 480px) {
            .products {
                display: flex;
                flex-direction: column-reverse;
            }

            .sumBlock {
                order: -1;
            }

            .info-container h2 {
                font-size: 16px;
            }

            .info-container p {
                font-size: 18px;
            }

            .grund-item {
                font-size: 24px;
            }

            .ende-item {
                font-size: 18px;
            }

            .remove-btn {
                font-size: 14px;
                padding: 4px;
            }

            .modal-content {
                width: 95%;
            }

            .payment-form-control {
                padding: 16px 10px;
            }
        }
    </style>
</head>
<body class="basket-page">
    <section class="products">
        <h2 class='abzac'>Your Cart</h2>
        <div class="grund">
            <div class="goods">
                <?php
                // Display cart items
                if (mysqli_num_rows($cart_query) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                        $selectedSize = $fetch_cart['size'];
                        $imagePath = getImagePath($fetch_cart);
                ?>
                <div class="card-container" data-item-id="<?php echo $fetch_cart['id']?>">
                    <div class="image-container">
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($fetch_cart['name']); ?>">
                    </div>
                    <div class="info-container">
                        <h2 style="color: white; font-size:30px;"><?php echo $fetch_cart['name']; ?></h2>
                        <p style="color: white; margin-top:60px; font-size:35px; font-weight: 900;">$ <?php echo $fetch_cart['price']; ?></p>
                        <p style="color: white; display: inline;">size:</p>
                        <select name="size" class="size-select" data-product-id="<?php echo $fetch_cart['id']; ?>">
                            <option value="S" <?php echo ($selectedSize == 'S') ? 'selected' : ''; ?>>S</option>
                            <option value="M" <?php echo ($selectedSize == 'M') ? 'selected' : ''; ?>>M</option>
                            <option value="L" <?php echo ($selectedSize == 'L') ? 'selected' : ''; ?>>L</option>
                            <option value="XL" <?php echo ($selectedSize == 'XL') ? 'selected' : ''; ?>>XL</option>
                        </select>

                        <form method="POST"  class="quantity" action="">
                            <p style="color: white; display: inline; margin">Quantity:</p>
                            <button type="button" name="incrementButton" onclick="decrementQuantity(<?php echo $fetch_cart['id'] ?>, <?php echo $fetch_cart['quantity'] ?> + 1)" style="background:#ddc8bf; border:none; text-align:center; font-size:20px; margin-left:40px;">-</button>
                            <input type="text" class="count-input" name="quantity[<?php echo $fetch_cart['id'] ?>]" style="width:17px; background:#ddc8bf; border:none; text-align:center; font-size:20px; margin-left:5px" value="<?php echo $fetch_cart['quantity']; ?>" readonly>
                            <button type="button" name="decrementButton" style="background:#ddc8bf; border:none; text-align:center; font-size:20px; margin-left:5px" onclick="incrementQuantity(<?php echo $fetch_cart['id'] ?>, <?php echo $fetch_cart['quantity'] ?> + 1)">+</button>
                        </form>
                        <button class="remove-btn" onclick="removeFromCart(<?php echo $fetch_cart['id']; ?>)"><i class="uil uil-trash-alt" name="delete_cart"></i></button>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="sumBlock">
            <div class="total-container">
                <div class="grund-item">Total Sum</div>
                <div class="infoGood">
                    <?php
                    // Calculate the total price of items in the cart
                    $cart_query_total = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='{$_SESSION['id']}'") or die('query failed');
                    $totalPrice = 0; 
                    while ($fetch_cart_total = mysqli_fetch_assoc($cart_query_total)) {
                        $itemName = $fetch_cart_total['name'];
                        $itemQuantity = $fetch_cart_total['quantity'];
                        $itemPrice = $fetch_cart_total['price'];
                        $itemTotalPrice = $itemPrice * $itemQuantity;
                        $totalPrice += $itemTotalPrice;
                    ?>
                    <div class="total-item">
                        <?php echo $itemName; ?> x<?php echo $itemQuantity; ?>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="total-item">Delivery Price: </div>
                <div class="promo">
                    <hr class="line">
                    <div class="total-item">Enter promo...</div>
                </div>
                <div class="ende-item">Total: $<?php echo $totalPrice; ?></div>
                <button id="checkoutButton" class="pay-all">Checkout</button>
            </div>
        </div>

        <!-- Add this modal for checkout -->
        <div id="checkoutModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Order Summary</h2>
                <div id="orderSummary"></div>
                <div id="totalAmount"></div>
                <form id="checkoutForm">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
                    <button type="submit">Confirm Purchase</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        var modal = document.getElementById("checkoutModal");
        var btn = document.getElementById("checkoutButton");
        var span = document.getElementsByClassName("close")[0];

        // Function to update the content of the checkout modal
        function updateModalContent() {
            var orderSummary = document.getElementById("orderSummary");
            var totalAmount = document.getElementById("totalAmount");
            var total = 0;

            orderSummary.innerHTML = ''; // Clear existing content

            $.ajax({
                url: '../../backend/get_cart_total.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response); // For debugging purposes
                    if (response.items && response.items.length > 0) { // Updated key name to 'items'
                        response.items.forEach(function(item) {
                            var itemTotal = item.price * item.quantity;
                            total += itemTotal;

                            var itemElement = `
                                <div class="payment-summary-item">
                                    <div class="payment-summary-name">${item.name} x${item.quantity}</div>
                                    <div class="payment-summary-price">$${itemTotal.toFixed(2)}</div>
                                </div>
                            `;
                            orderSummary.insertAdjacentHTML('beforeend', itemElement);
                        });
                        totalAmount.textContent = `$${total.toFixed(2)}`;
                    } else {
                        orderSummary.innerHTML = '<p>No items in the cart.</p>';
                        totalAmount.textContent = '$0.00';
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // For debugging purposes
                }
            });
        }

        // Open the modal and update its content when the checkout button is clicked
        btn.onclick = function() {
            updateModalContent();
            modal.style.display = "block";
        }

        // Close the modal when the close button is clicked
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Handle the checkout form submission
        $('#checkoutForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '../../backend/checkout.php',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('.goods').empty();
                        $('.infoGood').empty().append('<div class="total-item">No items in cart.</div>');
                        $('.ende-item').text('Total: $0.00');
                        modal.style.display = "none";
                    } else {
                        alert('Checkout failed. Please try again.');
                    }
                },
                error: function() {
                    alert('Checkout failed. Please try again.');
                }
            });
        });

        // Update the size of items in the cart
        $(document).ready(function() {
            $('.size-select').on('change', function() {
                var item_id = $(this).data('product-id');
                var new_size = $(this).val();

                // Log values for debugging
                console.log('Item ID:', item_id);  // Debugging
                console.log('New Size:', new_size);  // Debugging

                $.ajax({
                    url: '../../backend/update_size.php',
                    method: 'POST',
                    data: {
                        item_id: item_id,
                        new_size: new_size
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response);  // Debugging
                        if (response.success) {
                            console.log('Size updated successfully.');
                        } else {
                            console.error('Failed to update size:', response.message);
                            alert('Failed to update size: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', xhr.responseText);
                        alert('An error occurred while updating the size.');
                    }
                });
            });
        });
    </script>
    <script src="../JS/script.js"></script> <!-- Include the main JavaScript file -->
    <?php include "../components/footer.php"; ?> <!-- Include the footer component -->
    <script src="../JS/ajax.js"></script> <!-- Include the AJAX script -->
</body>
</html>
