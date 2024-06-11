<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
  include "../../backend/cards.php";
?>
<body class="product-seite">
    <sectio class="info-product">
    <?php
    // Connect to the database and retrieve item details based on the ID parameter
    include_once "../config/conn.php";
    // ...
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {
      // Получаем детали товара из запроса
      $itemId = $_POST['itemId'];
      $itemName = $_POST['itemName'];
      $itemPrice = $_POST['itemPrice'];
      $itemSize = $_POST['size'];
      $itemQuantity = $_POST['quantity'];
      $itemImage = $_POST['itemImage'];
  
      // Проверяем, есть ли уже товар с таким же itemId в таблице "basket"
      $checkQuery = "SELECT * FROM basket WHERE itemId = $itemId";
      $checkResult = mysqli_query($conn, $checkQuery);
  
      if (mysqli_num_rows($checkResult) > 0) {
          echo "Item already exists in the cart.";
      } else {
          // Вставляем товар в таблицу "basket"
          $insertQuery = "INSERT INTO basket (itemId, itemName, itemPrice, itemImage, typeName, size, quantity) VALUES ('$itemId', '$itemName', '$itemPrice', '$itemImage', '$typeName', '$itemSize', '$itemQuantity')";

          if (mysqli_query($conn, $insertQuery)) {
              echo "Item added to the cart successfully.";
          } else {
              echo "Error adding item to the cart: " . mysqli_error($conn);
          }
      }
  }
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
            // echo "<a class='add_cart' href='add_to_cart.php?id=$itemId'>Add to Cart</a>";
            echo "<form method='POST' action=''>";
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

        // Close the database connection
    } else {
        echo "<h5 class='price'>$$itemPrice</h5>";
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
            $limit = 3; // Установите лимит в 3 карточки
            $counter = 0; 
            while ($good = mysqli_fetch_assoc($cards)) {
                if ($counter < $limit) {
                    // Генерация HTML для карточки товара с помощью функции из card_template.php
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
                    <img src="../img/workpieces/product57.png" alt="">
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
  include "footer.php";
  ?> 
    <script src="../JS/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let offset = 3; // Установка начального смещения на 3

        function send() {
            $.ajax({
                type: "POST",
                url: "../../backend/cards.php",
                data: { offset: offset, limit: 3 }, // Указание лимита в 3 карточки
                success: function (data) {
                    $(".row").append(data);
                    offset += 3; // Увеличение смещения на 3 для следующего запроса
                },
                error: function () {
                    alert("Failed to load more cards.");
                }
            });
        }
        $(document).ready(function() {
            // Использование делегирования событий для привязки обработчика событий к родительскому контейнеру "row"
            $('.row').on('submit', '#form-submit', function(e) {
                e.preventDefault(); // Предотвращение стандартного поведения отправки формы

                var formData = $(this).serialize(); // Получение данных формы для отправки

                // Выполнение AJAX-запроса
                $.ajax({
                    type: 'POST',
                    url: "../../backend/add_basket_card.php",
                    data: formData,
                    success: function(response) {
                        console.log('Успешно добавлено в корзину!');
                        console.log(formData);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка при добавлении в корзину:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
