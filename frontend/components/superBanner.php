<?php


// This file is used to generate the HTML template for a single card
function generateSuperCard($good)
{


    $html = '
    <form method="post" class="mystar-card" data-product-id="' . htmlspecialchars($good['itemId']) . '" id="form-submit" action="">
    <div class="mystar-left">
    <img class="mystar-left-wordmark" src="../TrendClothes/' . '" alt=""/>
  </div>
  <div class="mystar-right">
  <img class="mystar-right-helmet" src="../img/exclusive/' . htmlspecialchars($good['itemImage']) .'" alt="helmet"/>
    <div class="mystar-productInfo">
      <h1 class="mystar-productInfo-title"> '. htmlspecialchars($good['itemName']) . '</h1>
      <h2 class="mystar-productInfo-price">' . htmlspecialchars($good['itemPrice']) .'$</h2>
      <div class="mystar-details">
        <p class="info-txt">'. htmlspecialchars($good['itemDescription']) .  '</p>
        <div class="mystar-durability">
        
        </div>
        <div class="button">
      <div class="button-layer"></div>
      <input type="hidden" name="image" value="' . $good["itemImage"] . '">
      <input type="hidden" name="category" value="' . $good["category"] . '">
      <input type="hidden" name="name" value="' . $good["itemName"] . '">
      <input type="hidden" name="price" value="' . $good["itemPrice"] . '">
      <button type="submit" class="mystar-productInfo-button" value="add to cart" name="addToCart">
      <input type="hidden" name="addToCart"> Buy</button>
      </div>
      
  </div>
               
    </div>
  </div>

  </form>

  ';
    

    return $html;
}

?>

