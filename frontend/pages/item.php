<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
@include "../../backend/cards.php";
?>
<style>
/* Ensure the row can flex and wrap properly */
.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around; /* Center the cards */
    margin-bottom: 20px; /* Add spacing at the bottom */
    margin-left: 0%; /* Add left margin */
    margin-right: 7%; /* Add right margin */
}

/* Add margin to each card to ensure proper spacing */
.card {
    flex: 1 0 30%; /* Ensure the card takes up about a third of the row */
    margin: 10px;
    box-sizing: border-box; /* Ensure padding and border are included in the width and height */
}

/* Add media query for responsiveness */
@media (max-width: 768px) {
    .card {
        flex: 1 0 45%; /* Adjust for smaller screens */
    }
}

/* Responsive styles */
@media (max-width: 468px) {
  .card {
        flex: 1 0 100%; /* Stack cards on very small screens */
    }
    .product-seite .content {
        flex-direction: column;
        align-items: center;
    }
    .product-seite .info {
        width: 90%;
        top: 0;
        margin-top: 20px;
    }
    .product-seite .info, .product-seite .dropdown, .product-seite .btns {
        align-items: center;
    }
    .product-seite .item {
        width: 90%;
        height: auto;
    }
    .product-seite .item img {
        width: 100%;
        height: auto;
    }
    .content-slider {
        margin-left: 0;
        width: 100%;
    }
    .mini-navbar {
        justify-content: center;
        flex-wrap: wrap;
    }
    .mini-navbar .nav-item {
        margin-bottom: 10px;
    }
}
</style>
<body class="product-seite">
    <section class="info-product">
    <?php
    // Connect to the database and retrieve item details based on the ID parameter
    @include_once "../config/conn.php";
    
    // Retrieve item details based on the ID parameter
    if (isset($_GET['id'])) {
        $itemId = $_GET['id'];

        // Fetch item details from the database
        $query = "SELECT * FROM produkte WHERE itemId = '$itemId'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $itemName = $row['itemName'];
            $itemPrice = $row['itemPrice'];
            $itemDescription = $row['itemDescription'];
            $itemImage = $row['itemImage'];

            echo "<div class='content'>";
            echo "<div class='item'>";
            echo "<img src='../img/catalogue/$itemImage' alt='$itemName' class='large-image'>";
            echo "</div>";
            
            echo "<div class='info'>";
            echo "<div class='dropdown'>";
            echo "<h2 class='name-product'>$itemName</h2>";
            echo "<div class='rating'>";
            echo "<input type='radio' id='star5' name='rating' value='5'><label for='star5'></label>";
            echo "<input type='radio' id='star4' name='rating' value='4'><label for='star4'></label>";
            echo "<input type='radio' id='star3' name='rating' value='3'><label for='star3'></label>";
            echo "<input type='radio' id='star2' name='rating' value='2'><label for='star2'></label>";
            echo "<input type='radio' id='star1' name='rating' value='1'><label for='star1'></label>";
            echo "</div>";
            echo "<h2 class='price'>$+$itemPrice</h2>";
    
            echo "</div>";

            echo '<p>choose your size:</p>';
            
            echo '<div class="size-chart">';
            echo '<div class="size-option">S</div>';
            echo '<div class="size-option">M</div>';
            echo '<div class="size-option">L</div>';
            echo '<div class="size-option">XL</div>';
            echo '</div>';

            echo '<div class="btns">';
            echo "<a href='#'><i class='fa-regular fa-heart'></i></a>";
            echo "<form method='POST' action='' class='add-to-cart-form'>";
            echo "<input type='hidden' name='itemId' value='$itemId'>";
            echo "<input type='hidden' name='itemName' value='$itemName'>";
            echo "<input type='hidden' name='itemPrice' value='$itemPrice'>";
            echo "<input type='hidden' name='size' value='S'>";
            echo "<input type='hidden' name='quantity' value='1'>";
            echo "<input type='hidden' name='itemImage' value='$itemImage'>";
            echo "<button type='submit' name='addToCart' style='border:none;'>Add to Cart</button>";
            echo "</form>";
            echo '</div>';
            echo "</div>";
            echo "</div>";
             
        } else {
            echo "Item not found.";
        }
    }
    ?>
    </section>
    <section class="info-content">
    <div class="mini-navbar">
        <div class="nav-item active" data-content="about">about</div>
        <div class="nav-item" data-content="specification">specification</div>
        <div class="nav-item" data-content="care">care</div>
    </div>

    <div class="content-slider">
        <div class="content-item active" data-content="about">
            <?php
            echo "<p class='info-txt'>$itemDescription</p>";
            echo "<p class='info-txt'>$itemDescription</p>";
            ?>
        </div>
        <div class="content-item" data-content="care">
            <div class="care">
                <div class="washing-instructions">
                    <h5>WASHING INSTRUCTIONS</h5>
                    <ul>
                        <li>Do not bleach.</li>
                        <li>Do not tumble dry.</li>
                        <li>Do not dry clean.</li>
                        <li>Touch up with cool iron.</li>
                        <li>Machine wash cold.</li>
                    </ul>
                </div>
                <div class="washing-instructions">
                    <h5>WASHING INSTRUCTIONS</h5>
                    <ul>
                        <li>Do not use fabric softener.</li>
                        <li>Use mild detergent only.</li>
                        <li>Wash with like colors.</li>
                        <li>Do not iron motif.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content-item" data-content="specification">
            <div class="specification"> 
                <div class="list-with-bullet">
                    <ul>
                        <li>Exclusive</li>
                        <li>Shorts sold separately</li>
                        <li>Crew neck</li>
                        <li>Graphic print to chest</li>
                        <li>Raw-cut hem</li>
                        <li>Cropped length</li>
                        <li>Oversized fit</li>
                    </ul>
                </div>
                <div class="list-with-bullet">
                    <ul>
                        <li>Sweatshirt fabric</li>
                        <li>Soft hand feel</li>
                        <li>Main: 100% Cotton.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="ende"><hr></div>
</section>   
<section class='log-seite'>
    <div class="row">
        <?php 
        $limit = 3; // Set the limit to 3 cards
        $counter = 0; 
        while ($good = mysqli_fetch_assoc($cards)) {
            if ($counter < $limit) {
                // Generate HTML for the product card using a function from card_template.php
                echo generateCardHTML($good);
                $counter++;
            } else {
                break; 
            }
        }
        ?>
    </div>
</section>

<section class="advertising" id="banner">
    <div class="max-width">
        <div class="ad-content">
            <div class="column center">
                <img class="centerbanner" src="../img/workpieces/Group.png" alt="">
            </div>
            <div class="column left">
                <img src="../img/workpieces/image55.png" alt="">
            </div>
            <div class="column right">
                <img src="../img/workpieces/image57.png" alt="">
            </div>
            <div class="column price">
                <img src="../img/workpieces/price.png" alt="">
            </div>
            <div class="column btn">
                <a href="#"><h4>MORE INFO</h4></a>
            </div>
        </div> 
    </div>      
</section>
<?php
include "../components/footer.php";
?> 
<script src="../JS/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    let offset = 3; // Set the initial offset to 3

    function send() {
        $.ajax({
            type: "POST",
            url: "../../backend/cards.php",
            data: { offset: offset, limit: 3 }, // Specify the limit of 3 cards
            success: function (data) {
                $(".row").append(data);
                offset += 3; // Increase the offset by 3 for the next request
            },
            error: function () {
                alert("Failed to load more cards.");
            }
        });
    }

</script>
</body>
</html>
