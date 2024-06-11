<?php
// This file is used to generate the HTML template for a single card
function generateCardHTML($good)
{
    $html = '
    <form method="post" class="card" id="form-submit" action="">
    <a href="item.php?id=' . htmlspecialchars($good['itemId']) . '">
          <div class="product-card" >
            <div class="logo-cart">
                <img src="../img/workpieces/blackMask.png" alt="logo">
            </div>
            <div class="main-images">
                <img class="blue active" src="../img/catalogue/' . htmlspecialchars($good['itemImage']) . '" alt="' . htmlspecialchars($good['itemName']) . '">
                <img id="pink" class="pink" src="../img/red.webp" alt="Alternative">
                <img id="yellow" class="yellow" src="../img/black.webp" alt="Alternative">
            </div>
            <div class="shoe-details">
                <span class="shoe_name">' . htmlspecialchars($good['itemName']) . '</span>
                <p>All items are original and tested by us. Otherwise, we will refund your money.</p>
                <div class="stars">
                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i><i class="bx bxs-star"></i>
                    <i class="bx bx-star"></i>
                </div>
            </div>
            <div class="color-price">
                <div class="color-option">
                    <span class="color">Colour:</span>
                    <div class="circles">
                        <span class="circle blue active" id="blue"></span>
                        <span class="circle pink" id="pink"></span>
                        <span class="circle yellow" id="yellow"></span>
                    </div>
                </div>
                <div class="price">
                    <span class="price_num">' . htmlspecialchars($good['itemPrice']) . '</span>
                    <span class="price_letter">Nine dollar only</span>
                </div>
            </div>
            </a>
            <div class="button">
                <div class="button-layer"></div>
                <input type="hidden" name="image" value="' . $good["itemImage"] . '">
                <input type="hidden" name="name" value="' . $good["itemName"] . '">
                <input type="hidden" name="price" value="' . $good["itemPrice"] . '">
                <button type="submit" class="buyBtn" value="add to cart" name="addToCart">
                <input type="hidden" name="addToCart"> Buy</button>
            </div>
        </div>   
    </form>';

    return $html;
}

?>