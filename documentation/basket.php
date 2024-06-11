<?php
session_start();
include "header.php";
include "navbar.php";
// Connect to the database
include_once "../config/conn.php";
include_once "../backend/add_basket_card.php";
include "../backend/delete_cart.php"

?>

<body class="basket-page">
    <section class="products">
        <h2 class='abzac'>Your Cart</h2>
        <div class="grund">
            <div class="goods">
                  <?php
       $cart_quary = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='$user_id'") or die('query failed');
if (mysqli_num_rows($cart_quary) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($cart_quary)) {
?>
<div class="card-container" data-item-id="<?php echo $fetch_cart['id']?>">
    <div class="image-container">
    <img src="../img/<?php echo $fetch_cart['image']; ?>" alt="<?php echo $fetch_cart['name']; ?>">
    </div>
    <div class="info-container">
        <h2 style="color: white; font-size:30px;"><?php echo $fetch_cart['name']; ?></h2>
        <p style="color: white; margin-top:60px; font-size:35px; font-weight: 900;">$ <?php echo $fetch_cart['price']; ?></p>
        <p style="color: white; display: inline;">size:</p>
        <select name="size" style="color: display: inline; margin-left:80px; font-size:20px; width:50px; text-align:center; background:#ddc8bf;">
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select>
        <form>
            <p style="color: white; display: inline; margin">Quantity:</p>
            <button type="button" style="margin-left:45px; background:#ddc8bf; border:none; text-align:center; font-size:20px" onclick="decrement(this, <?php echo $itemQuantity; ?>)">-</button>
            <input type="text" class="count-input" name="quantity[<?php echo $fetch_cart['id'] ?>]" style="width:17px; background:#ddc8bf; border:none; text-align:center; font-size:20px; margin-left:5px" value="<?php echo $fetch_cart['quantity']; ?>" readonly>
            <button type="button" style="background:#ddc8bf; border:none; text-align:center; font-size:20px; margin-left:5px" onclick="increment(this, <?php echo $itemQuantity; ?>)">+</button>
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

    <!-- Поместите цикл while вокруг контейнера card-container -->
    <?php
    $cart_quary = mysqli_query($conn, "SELECT * FROM `basket` WHERE user_id='$user_id'") or die('query failed');
    $totalPrice = 0; 
    while ($fetch_cart = mysqli_fetch_assoc($cart_quary)) {
        // Получаем данные товара из текущей строки результата
        $cardId = $fetch_cart['id'];
        $itemName = $fetch_cart['name'];
        $itemPrice = $fetch_cart['price'];
        $itemQuantity= $fetch_cart['quantity'];
        $totalPrice+=$itemPrice*$itemQuantity;
    ?>
        <!-- Выводим информацию о товаре -->
        <div class="card-info">
            <div class="total-item"><?php echo $itemName.' / $'.$itemPrice.' x'.$itemQuantity; ?></div>
            <?php
    }
    ?>
            <div class="total-item">Delivery Price: </div>
            <div class="promo">
                <hr class="line">
                <div class="total-item">Enter promo...</div>
                <hr class="line">
            </div>
            <div class="ende-item">Total: $<?php echo $totalPrice; ?></div>
        </div>
</div>
</div>


    </section>
    <script src="/vogueVibes/JS/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <?php include "footer.php"; ?>
    <script>
    function removeFromCart(cardId) {
    $.ajax({
        type: "POST",
        url: "../backend/delete_cart.php",
        data: { cardId: cardId },
        dataType: "json",
        success: function (data) {
            if (data.statusCode === 200) {
                // Успешно удалено
                $(".card-container[data-item-id='" + cardId + "']").remove(); // Удаляем карточку из DOM
                // updateTotalPrice(); // Обновляем общую сумму, если необходимо
            } else if (data.statusCode === 500) {
                // Ошибка при удалении
                alert(data.message);
            }
        },
        error: function () {
            // Ошибка при отправке AJAX-запроса
            alert("Failed to delete the card.");
        }
    });
}

    </script>
</body>

</html>

