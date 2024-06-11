<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
include "../../backend/superCard.php";

include "../../backend/changer_baner.php";
?>
<style>
.banner,
.collection-wrapper {
    background: none; /* Убираем переопределяющие фоны, если они были */
      width: 100%;
    height: 600px;
}

.section-full-background {
    width: 100%;
    background: url("../img/workpieces/fon.png") no-repeat center center; /* Центрирование фона */
    background-size: cover; /* Покрытие всей доступной области */
    padding: 20px;
    position: relative;
    color: #000;
}
.collection-wrapper {
    width: 100%;
    /* background: url("../img/fon.png") no-repeat center; */
    height: 100%;
    max-width: 2048px;
    margin: 0 auto;
    text-align: center;
    color: #000;
    /* padding: 20px; */
}

.hats, .collection-items {
    display: flex;
    justify-content: center;    
}

.hats img {
    width: 15%; /* Меньший размер для головных уборов */
    margin: 0 30px; /* Увеличиваем отступы справа и слева до 10px */
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease;
    margin-bottom: -60px;
}

.collection-items {
    display: flex;
    height: 330px;
    justify-content: center;
    position: relative;
    margin-bottom: 0px; /* Уберем отступ снизу, если он был */

}

.collection-items img {
    width: 450px; /* Сохраняем пропорции изображения */
    height: 350px; 
    position: absolute;
    transition: transform 0.8s ease, opacity 0.8s ease;
    opacity: 0; /* Начальное состояние для анимации */
    transform: translateY(50px);
}

/* Центральное изображение */
.collection-items img:nth-child(3) {
    left: 45%; /* Позиция по центру */
    transform: translateX(-50%) scale(1.1); /* Центрирование и увеличение */
    z-index: 9;
}

/* Боковые изображения, слева и справа от центра */
.collection-items img:nth-child(2) {
    right: 45%; /* Отступ слева для левого изображения */
    transform: translateX(-50%) scale(0.9); /* Смещение и уменьшение */
    z-index: 9;
}

.collection-items img:nth-child(4) {
    left: 55%; /* Отступ справа для правого изображения */
    transform: translateX(-50%) scale(0.9); /* Смещение и уменьшение */
 
}

/* Дополнительные изображения за первыми боковыми */
.collection-items img:nth-child(1) {
    transform: translateX(-50%) scale(0.8); /* Дальнейшее смещение и уменьшение */
    z-index: 99999;
}

.collection-items img:nth-child(5) {
    right: 55%; /* Дальше вправо */
    transform: translateX(-50%) scale(0.8); /* Дальнейшее смещение и уменьшение */
}

.animated-item {
    opacity: 1;
    transform: translateY(0) scale(1); /* Анимация возвращения на место */
}


.collection-items img.animated, .hats img.animated {
    opacity: 1;
    transform: translateX(0) translateY(0);
}

.exlusive-seite {
  height: 100%;
  position: relative;
  background-color: black; 
}

.exlusive-seite::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 50%; 
  height: 100%; 
  background: linear-gradient(to right, black 0%, transparent 50%), url('../img/workpieces/boy.png');
  background-repeat: no-repeat;
  background-size: cover; 
  transform: scaleX(-1); 
  background-position: left bottom; 
}
@media screen and (max-width: 576px) {
  .mystar-card {
    
    /* transform: rotate(90deg) scale(0.7) translate(calc(50% - 25vh), 50%); */
    /* position: static; */
  }
}

@media (max-width: 690px) {
  .hats{
    bottom: 150px;
    position: absolute;
  }
    .hats img {
       width: 100px;
       height: 100px;
        margin: 0 15px; /* Сокращаем отступы */
    }
   
    .section-full-background{
      padding: 0px;
    }
    .collection-items img {
      width: 45%; /* Сохраняем пропорции изображения */
    height:50%; 
    position: absolute;
    bottom: 0; /* Прижимаем к нижнему краю */

    }


}
  </style>
<main>
    <div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>    
    <!-- home section start -->
    <section class="home" id="home">
        <div class="max-width">
            <div class="home-content">
                <div class="icons"><img src="../img/workpieces/newlogo.png"></div>
                <div class="text-2">VOGUE VIBES</div>
                <a href="#" class="btn"><h4>Start Shoping</h4></a>
                <a  class="btnarrow arrow-animation" href="#banner"><i class="fa fa-chevron-down"></i></a>
            </div>
        </div>
    </section>
    <section class="section-full-background">

<div class="banner" id="banner">
        <div class="max-width">
          <div class="banner-content">
            <div class="column left">
              <img src="../img/workpieces/image.png" alt="">
            </div>
            <div class="column right">
              <img src="../img/workpieces/image62.png" alt="">
            </div>
            <div class="column center">
              <img class="centerbanner" src="../img/workpieces/NEWARRIVALS.png" alt="">
            </div>
          </div>
        </div>
        </div>
    <!-- banner section start -->
      <div class="collection-wrapper">
      <h2 style="font-size:50px">Examples of our collections</h2>
      <div class="hats">
        <img src="https://optim.tildacdn.com/tild6536-6538-4630-b436-353731336235/-/resize/492x/-/format/webp/2723842690.png" alt="Черная капюшонка" class="animated-item" data-delay="500">
        
        <div class="hat-description">
            <p style="font-size:27px;margin-top:20px">Save and Preserve Collection <br> by VSRAP x CMH</p>
        </div>

        <img src="https://optim.tildacdn.com/tild3232-3362-4832-a333-316437346234/-/resize/386x/-/format/webp/2667709060_1.png" alt="Дополнительная фотография 2" class="animated-item" data-delay="700">
    </div>
    <div class="collection-items">
         <img src="https://static.tildacdn.com/tild3739-3231-4265-b065-373163383163/2723875963_1.png" alt="Шляпа" class="animated-item" data-delay="100">
         <img src="https://static.tildacdn.com/tild6532-3139-4231-b666-343234343835/2667706935.png" alt="Красный джерси" class="animated-item" data-delay="400">
         <img src="https://static.tildacdn.com/tild3036-3433-4236-b533-356431353238/2723736637.png" alt="Худи" class="animated-item" data-delay="300">
        <img src="https://static.tildacdn.com/tild3930-3436-4563-a264-343963393338/2667715841_1.png" alt="Черная футболка" class="animated-item" data-delay="200">
        <img src="https://optim.tildacdn.com/tild3536-3364-4130-b237-393630663035/-/resize/872x/-/format/webp/2723871378.png" alt="Дополнительная фотография 1" class="animated-item" data-delay="600">
       
    </div>
        </div>
</section>

    <section class="main-section" id='banner'>
    <div class='exlusive-seite'>
        <div class="block-text">
        <span class="letter" id="n" style="position: relative;">N</span>
    <span class="letter" id="e" style="position: relative;">E</span>
    <span class="letter" id="w" style="position: relative;">W</span>
    <span class="letter" id="p" style="position: relative;">P</span>
    <span class="letter" id="r" style="position: relative;">R</span>
    <span class="letter" id="o" style="position: relative;">O</span>
    <span class="letter" id="d" style="position: relative;">D</span>
    <span class="letter" id="u" style="position: relative;">U</span>
    <span class="letter" id="c" style="position: relative;">C</span>
    <span class="letter" id="t" style="position: relative;">T</span>
    <span class="letter" id="s" style="position: relative;">S</span>
        </div>
        
        <div class="clothesSet">
            <!-- PHP Script to display the product card -->
            <?php 
             if ($good = mysqli_fetch_assoc($cards)) {
              echo generateSuperCard($good);
          }
            ?>

        </div>
        <div class="mystar-slider mystar-slider-prev" data-direction="prev">
        <h1><</h1>
    </div>
    <div class="mystar-slider mystar-slider-next" data-direction="next">
        <h1>></h1>
    </div>
    </div>
</section>



      <!-- nanner section start -->
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
<section class="gallery">
   <div class="slider">
      <div class="options">
         <div class="option" style="--optionBackground:url(../img/workpieces/gallery6.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
               <i class="fas fa-walking"></i>
            </div>
            <div class="info">
               <div class="main">Sport</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>

      <div class="option" style="--optionBackground:url(../img/workpieces/gallery7.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
            <i class="fa-solid fa-basketball"></i>
            </div>
            <div class="info">
               <div class="main">Basketball</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>
      <div class="option" style="--optionBackground:url(../img/workpieces/gallery2.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
            <i class="fa-solid fa-basketball"></i>
            </div>
            <div class="info">
               <div class="main">Basketball</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>
      <div class="option active" style="--optionBackground:url(../img/workpieces/gallery1.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
            <i class="fa-solid fa-basketball"></i>
            </div>
            <div class="info">
               <div class="main">Sport</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>
      <div class="option" style="--optionBackground:url(../img/workpieces/gallery3.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
            <i class="fa-solid fa-city"></i>
            </div>
            <div class="info">
               <div class="main">Street</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>
      <div class="option" style="--optionBackground:url(../img/workpieces/gallery4.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
            <i class="fas fa-sun"></i>
            </div>
            <div class="info">
               <div class="main">Basketball</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>
      <div class="option" style="--optionBackground:url(../img/workpieces/gallery5.png);">
         <div class="shadow"></div>
         <div class="label">
            <div class="icon">
               <i class="fas fa-sun"></i>
            </div>
            <div class="info">
               <div class="main">Summer</div>
               <div class="sub">Sportswear and summer wear</div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>

      <?php
  include "../components/footer.php";
  ?>
    <script src="../JS/script.js"></script>
      <!-- <script src="/vogueVibes/JS/script.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submissions for product cards
    $('.clothesSet').on('submit', '.mystar-card', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "../../backend/add_basket_card.php",
            data: formData,
            success: function(response) {
                console.log('Successfully added to cart!');
                console.log(formData);
            },
            error: function(xhr, status, error) {
                console.error('Error when adding to cart:', error);
            }
        });
    });

    // Handle clicks on slider navigation buttons
    $(document).ready(function() {
    $('.mystar-slider-next, .mystar-slider-prev').on('click', function() {
        var $this = $(this);
        var direction = $this.hasClass('mystar-slider-next') ? 'next' : 'prev';
        var currentId = $('.clothesSet .mystar-card').data('product-id');

        // Проверка на наличие продукта
        if (!currentId) {
            console.error("Product ID is undefined or invalid.");
            alert('Invalid or missing product ID.');
            return;
        }

        // Отправляем запрос на сервер для проверки
        $.ajax({
            url: '../../backend/changer_baner.php',
            type: 'POST',
            dataType: 'json',  // ожидаем данные в формате JSON
            data: {id: currentId, dir: direction},
            success: function(response) {
                if (!response.endOfData) {
                    $('.clothesSet').html(response.html);
                } else {
                    // Ничего не делаем, если достигнут конец данных
                    console.log('No more products to display.');
                    // Опционально, можно добавить какой-то UI элемент или сообщение
                    $this.prop('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading new product:', error);
                alert('Error loading new product: ' + error);
            }
        });
    });
});
});
$(window).scroll(function() {
    $('.animated-item').each(function(){
        var itemPos = $(this).offset().top;
        var topOfWindow = $(window).scrollTop();
        if (itemPos < topOfWindow + 800) {
            $(this).css("transition-delay", $(this).data("delay") + "ms");
            $(this).addClass("animated");
        }
    });
});

</script>

</main>