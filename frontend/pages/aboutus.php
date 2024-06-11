<?php
session_start();
include "../components/header.php"; // Путь к header.php
include "../components/navbar.php"; // Путь к navbar.php
?>
<body class="about-page">
    <section class="aboutus">
    <div class="containerone"></div>
    <div class="containertwo"></div>
    <div class="containerthree"></div>
      <div class="content">
      <div class="vogue">
          <img src="../img/workpieces/basketball.png" class="image image4">
          <div class="vogue-vibes"></div>
      </div>
      <div class="info1">
        <p>We are a company that produces affordable streetwear since 2009. We pride ourselves in
        our worldwide reach. Our target audience is college students. We want to convey a
        sense of eagerness, while at the same time being lively.
        </p>
      </div>
      <div class="info2">
        <p> Many people think that "street is life" means street is life. 
          What it really means is that in order to make it in life you must put in the work and grind it out. 
          Success never comes easy, you have to work at it and craft your skill. Essentially, you have to ball
        </p>
      </div>
      <div class="vibes">
        <h1>STAY BOLD</h1>
        <div class="vibesGallery">
            <img src="../img/workpieces/mamba.png" class="image image5">
            <img src="../img/workpieces/staybold.png" class="image image6">
        </div>
      </div>
      <div class="cards">
         <h2 class="header">
         You can also find us here
         </h2>
         <div class="services">
            <div class="contents contents-1">
               <div class="fab fa-twitter"></div>
               <h2>
                  Twitter
               </h2>
               <p>
               You can find us on social networks We also publish information about our store there.               </p>
               <a href="#">Read More</a>
            </div>
            <div class="contents contents-2">
               <div class="fab fa-instagram"></div>
               <h2>
                  Instagram
               </h2>
               <p>
               You can find us on social networks We also publish information about our store there.               </p>
               <a href="#">Read More</a>
            </div>
            <div class="contents contents-3">
               <div class="fab fa-youtube"></div>
               <h2>
                  Youtube
               </h2>
               <p>
               You can find us on social networks We also publish information about our store there.               </p>
               <a href="#">Read More</a>
            </div>
         </div>
      </div>
    </div> 
    </section>
    <?php 
    include "../components/footer.php"
    ?>
    <script src="../JS/script.js"></script>
</body>

