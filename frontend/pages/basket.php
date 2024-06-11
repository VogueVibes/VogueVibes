<?php
session_start();
include "../components/header.php"; // Путь к header.php
include "../components/navbar.php"; // Путь к navbar.php
// Connect to the database
include_once "../../config/conn.php";
include_once "../../backend/add_basket_card.php";
include "../../backend/delete_cart.php";
include "../../backend/decrement.php";
$selectedSize = $fetch_cart['size']; // предполагается, что размер сохранён в поле 'size' в таблице 'basket'

// Function to determine the image path
function getImagePath($item) {
    $baseDir = '../img/';
    $brandDir = 'exclusive/';
    $regularDir = 'catalogue/';

    if ($item['category'] === 'brand') {
        $path = $baseDir . $brandDir . $item['image'];
    } else {
        $path = $baseDir . $regularDir . $item['image'];
    }

    // Check if file exists on server
    if (file_exists($path)) {
        return $path;
    } else {
        return $baseDir . 'default.png'; // Default image if not found
    }
}

// Fetch user's cart items
$cart_query = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='$user_id'") or die('Query failed');

?>
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
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    animation: fadeIn 0.5s;
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}

.close {
    color: #aaa;
    float: right;
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






.container {
    max-width: 940px;
    margin: 0 auto;
    padding: 0 16px;
}
/* end: Globals */



/* start: Payment */
.payment-section {
    padding: 48px 0;
}
.payment-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.payment-header {
    padding: 24px;
    background-color: var(--indigo-500);
    border-radius: 12px;
    padding-bottom: 72px;
}
.payment-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: var(--indigo-600);
    color: var(--white);
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}
.payment-header-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--white);
    line-height: 1.4;
    margin-bottom: 4px;
}
.payment-header-description {
    font-size: 15px;
    color: var(--gray-200);
    line-height: 1.5;
}
.payment-content {
    padding: 24px;
    margin-top: -64px;
    position: relative;
}
.payment-content::before {
    content: '';
    position: absolute;
    top: 24px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 32px);
    height: 16px;
    border-radius: 4px;
    background-color: var(--indigo-600);
}
.payment-body {
    background-color: var(--white);
    border-radius: 0 0 8px 8px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, .05), inset 0 8px 0 rgba(0, 0, 0, .05);
    position: relative;
    padding-top: 8px;
    overflow: hidden;
}
.payment-plan {
    display: flex;
    align-items: center;
    padding: 12px;
}
.payment-plan-type {
    width: 40px;
    height: 40px;
    background-color: var(--indigo-500);
    color: var(--white);
    font-size: 13px;
    font-weight: 600;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    margin-right: 8px;
}
.payment-plan-info {
    width: 100%;
    margin-right: 8px;
    display: grid;
}
.payment-plan-info-name {
    font-size: 13px;
    color: var(--gray-400);
    margin-bottom: 2px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.payment-plan-info-price {
    font-weight: 600;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.payment-plan-change {
    color: var(--blue-500);
    font-size: 12px;
    font-weight: 600;
    text-underline-offset: 2px;
}
.payment-plan-change:hover {
    color: var(--blue-600);
}
.payment-summary-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 12px;
}
.payment-summary-name {
    font-size: 14px;
    color: var(--gray-500);
}
.payment-summary-price {
    font-weight: 500;
    font-size: 15px;
}
.payment-summary-divider {
    width: calc(100% - 16px);
    height: 0;
    margin: 12px auto;
    border-bottom: 1px dashed var(--gray-200);
    position: relative;
}
.payment-summary-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 100%;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: var(--gray-50);
    box-shadow: inset 0 2px 16px rgba(0, 0, 0, .05);
}
.payment-summary-divider::after {
    content: '';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 100%;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: var(--gray-50);
    box-shadow: inset 0 2px 16px rgba(0, 0, 0, .05);
}
.payment-summary-total {
    padding-bottom: 16px;
}
.payment-summary-total .payment-summary-name {
    color: var(--gray-900);
}
.payment-summary-total .payment-summary-price {
    font-size: 16px;
    color: var(--indigo-500);
    font-weight: 600;
}
.payment-right {
    min-width: 0;
}
.payment-form {
    padding: 24px;
    background-color: var(--white);
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, .05);
}
.payment-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.3;
}
.payment-method {
    display: flex;
    align-items: center;
    overflow-x: auto;
    padding: 6px 0;
    margin-bottom: 12px;
    width: 100%;
}
.payment-method input {
    display: none;
}
.payment-method-item {
    width: 80px;
    height: 80px;
    padding: 8px;
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    margin-right: 12px;
    cursor: pointer;
    position: relative;
    flex-shrink: 0;
}
input:checked + .payment-method-item {
    border-color: var(--indigo-500);
}
input:checked + .payment-method-item::before {
    content: '';
    position: absolute;
    top: -6px;
    right: -6px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background-color: var(--indigo-500);
    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZD0iTTEwLjAwMDcgMTUuMTcwOUwxOS4xOTMxIDUuOTc4NTJMMjAuNjA3MyA3LjM5MjczTDEwLjAwMDcgMTcuOTk5M0wzLjYzNjcyIDExLjYzNTRMNS4wNTA5MyAxMC4yMjEyTDEwLjAwMDcgMTUuMTcwOVoiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMSkiPjwvcGF0aD48L3N2Zz4=");
    background-size: 12px;
    background-position: center;
    background-repeat: no-repeat;
}
.payment-method-item > img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.payment-form-group {
    position: relative;
    margin-bottom: 16px;
}
.payment-form-control {
    outline: transparent;
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    padding: 24px 16px 8px 16px;
    width: 100%;
    transition: all .15s ease-in-out;
}
.payment-form-label {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 16px;
    color: var(--gray-400);
    pointer-events: none;
    transition: all .1s ease-in-out;
}
.payment-form-control:focus {
    outline: 1px solid var(--indigo-500);
    border-color: var(--indigo-500);
}
.payment-form-control:focus + .payment-form-label,
.payment-form-control:not(:placeholder-shown) + .payment-form-label {
    top: 30%;
    font-size: 12px;
}
.payment-form-label-required::after {
    content: ' *';
    color: var(--red-500);
}
.payment-form-group-flex {
    display: flex;
    align-items: center;
}
.payment-form-group-flex > * {
    width: 100%;
}
.payment-form-group-flex > :not(:last-child) {
    margin-right: 12px;
}
.payment-form-submit-button {
    background-color: var(--indigo-500);
    border-radius: 8px;
    outline: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    border: none;
    cursor: pointer;
    color: var(--white);
    font-weight: 600;
    padding: 16px;
    transition: all .15s ease-in-out;
}
.payment-form-submit-button:hover {
    background-color: var(--indigo-600);
}
.payment-form-submit-button > i {
    margin-right: 8px;
}
/* end: Payment */



/* start: Breakpoints */
@media screen and (max-width: 767px) {
    .payment-wrapper {
        grid-template-columns: 1fr;
    }
    .payment-content {
        padding: 16px;
    }
    .payment-content::before {
        top: 16px;
        width: calc(100% - 20px);
    }
    .payment-form-group-flex {
        display: block;
    }
}
/* end: Breakpoints */
</style>
<body class="basket-page">
    <section class="products">
        <h2 class='abzac'>Your Cart</h2>
        <div class="grund">
            <div class="goods">
            <?php
                if (mysqli_num_rows($cart_query) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                        $imagePath = getImagePath($fetch_cart); // Get the correct image path
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
            $cart_query_total = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='$user_id'") or die('query failed');
            $totalPrice = 0; 
            while ($fetch_cart_total = mysqli_fetch_assoc($cart_query_total)) {
                // Get item details from the current row
                $itemName = $fetch_cart_total['name'];
                $itemQuantity = $fetch_cart_total['quantity'];
                $itemPrice = $fetch_cart_total['price'];

                // Calculate the total price for this item
                $itemTotalPrice = $itemPrice * $itemQuantity;
                $totalPrice += $itemTotalPrice;
            ?>
            <!-- Display the item information -->
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
            <!-- <hr class="line"> -->
        </div>
        <div class="ende-item">Total: $<?php echo $totalPrice; ?></div>
        <button id="checkoutButton" class="pay-all">Checkout</button>
    </div>
</div>

<!-- Modal -->
<div id="checkoutModal" class="modal">
    <div class="modal-content">
    <!-- start: Payment -->
    <section class="payment-section">
            <div class="container">
                <div class="payment-wrapper">
                    <div class="payment-left">
                        <div class="payment-header">
                            <div class="payment-header-icon"><i class="ri-flashlight-fill"></i></div>
                            <div class="payment-header-title">Order Summary</div>
                            <p class="payment-header-description">Review your order before proceeding to payment.</p>
                        </div>
                        <div class="payment-content">
                            <div class="payment-body">
                                <div class="payment-summary" id="orderSummary">
                                    <!-- Items will be dynamically added here -->
                                </div>
                                <div class="payment-summary-divider"></div>
                                <div class="payment-summary-item payment-summary-total">
                                    <div class="payment-summary-name">Total</div>
                                    <div class="payment-summary-price" id="totalAmount">    <div class="ende-item">Total: $<?php echo $totalPrice; ?></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment-right">
                        <form action="" class="payment-form">
                            <h1 class="payment-title">Payment Details</h1>
                            <div class="payment-method">
                                <input type="radio" name="payment-method" id="method-1" checked>
                                <label for="method-1" class="payment-method-item">
                                    <img src="images/visa.png" alt="">
                                </label>
                                <input type="radio" name="payment-method" id="method-2">
                                <label for="method-2" class="payment-method-item">
                                    <img src="images/mastercard.png" alt="">
                                </label>
                                <input type="radio" name="payment-method" id="method-3">
                                <label for="method-3" class="payment-method-item">
                                    <img src="images/paypal.png" alt="">
                                </label>
                                <input type="radio" name="payment-method" id="method-4">
                                <label for="method-4" class="payment-method-item">
                                    <img src="images/stripe.png" alt="">
                                </label>
                            </div>
                            <div class="payment-form-group">
                                <input type="email" placeholder=" " class="payment-form-control" id="email">
                                <label for="email" class="payment-form-label payment-form-label-required">Email Address</label>
                            </div>
                            <div class="payment-form-group">
                                <input type="text" placeholder=" " class="payment-form-control" id="card-number">
                                <label for="card-number" class="payment-form-label payment-form-label-required">Card Number</label>
                            </div>
                            <div class="payment-form-group-flex">
                                <div class="payment-form-group">
                                    <input type="date" placeholder=" " class="payment-form-control" id="expiry-date">
                                    <label for="expiry-date" class="payment-form-label payment-form-label-required">Expiry Date</label>
                                </div>
                                <div class="payment-form-group">
                                    <input type="text" placeholder=" " class="payment-form-control" id="cvv">
                                    <label for="cvv" class="payment-form-label payment-form-label-required">CVV</label>
                                </div>
                            </div>
                            <button type="submit" class="payment-form-submit-button"><i class="ri-wallet-line"></i> Pay</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <!-- end: Payment -->
    </div>
</div>
    </section>
    <script>
       // Get the modal
var modal = document.getElementById("checkoutModal");

// Get the button that opens the modal
var btn = document.getElementById("checkoutButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Function to update the modal content
function updateModalContent() {
    var orderSummary = document.getElementById("orderSummary");
    var totalAmount = document.getElementById("totalAmount");
    var total = 0;

    orderSummary.innerHTML = ''; // Clear existing content

    // Fetch cart items
    $.ajax({
        url: '../../backend/services/get_cart_total.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            response.cartItems.forEach(function(item) {
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
        }
    });
}

// When the user clicks the button, open the modal and update content
btn.onclick = function() {
    updateModalContent();
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

    </script>
    <script src="../JS/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <?php include "../components/footer.php"; ?>
    <script src="../JS/ajax.js"></script>
    
</body>
</html>
