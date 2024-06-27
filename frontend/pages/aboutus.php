<?php
session_start();
include "../components/header.php"; // Include the header component
include "../components/navbar.php"; // Include the navbar component
?>
<body class="about-page">
    <section class="aboutus">
        <div class="containerone"></div> <!-- Decorative container one -->
        <div class="containertwo"></div> <!-- Decorative container two -->
        <div class="containerthree"></div> <!-- Decorative container three -->
        <div class="content">
            <div class="vogue">
                <img src="../img/workpieces/basketball.png" class="image image4"> <!-- Vogue vibes image -->
                <div class="vogue-vibes"></div> <!-- Placeholder for dynamic content -->
            </div>
            <div class="info1">
                <p>
                    We are a company that produces affordable streetwear since 2009. We pride ourselves in
                    our worldwide reach. Our target audience is college students. We want to convey a
                    sense of eagerness, while at the same time being lively.
                </p>
            </div>
            <div class="info2">
                <p>
                    Many people think that "street is life" means street is life. 
                    What it really means is that in order to make it in life you must put in the work and grind it out. 
                    Success never comes easy, you have to work at it and craft your skill. Essentially, you have to ball.
                </p>
            </div>
            <div class="vibes">
                <h1>STAY BOLD</h1> <!-- Stay bold section heading -->
                <div class="vibesGallery">
                    <img src="../img/workpieces/mamba.png" class="image image5"> <!-- Gallery image one -->
                    <img src="../img/workpieces/staybold.png" class="image image6"> <!-- Gallery image two -->
                </div>
            </div>
            <div class="cards">
                <h2 class="header">
                    You can also find us here
                </h2>
                <div class="services">
                    <div class="contents contents-1">
                        <div class="fab fa-twitter"></div> <!-- Twitter icon -->
                        <h2>Twitter</h2>
                        <p>
                            You can find us on social networks. We also publish information about our store there.
                        </p>
                        <a href="#">Read More</a>
                    </div>
                    <div class="contents contents-2">
                        <div class="fab fa-instagram"></div> <!-- Instagram icon -->
                        <h2>Instagram</h2>
                        <p>
                            You can find us on social networks. We also publish information about our store there.
                        </p>
                        <a href="#">Read More</a>
                    </div>
                    <div class="contents contents-3">
                        <div class="fab fa-youtube"></div> <!-- YouTube icon -->
                        <h2>Youtube</h2>
                        <p>
                            You can find us on social networks. We also publish information about our store there.
                        </p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php 
    include "../components/footer.php"; // Include the footer component
    ?>
    <script src="../JS/script.js"></script> <!-- Include the main JavaScript file -->
</body>
