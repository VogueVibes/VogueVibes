
    <?php if(isset($_SESSION["username"]) && ($_SESSION["role"])==0){ ?>
            <!-- <i class="fa-solid fa-user"></i>
              <?php echo $_SESSION['username'] ?></strong> -->
            <nav class="my-navbar">
      <div class="left-half">
        <button class="my-btn btn-left">Catalog</button>
      </div>
     <a href="../pages/index.php"> <div class="logo"><img src="/vogueVibes_New/frontend/img/workpieces/LOGO.png"></div></a>
      <div class="right-half">
      <a href="../pages/aboutus.php"><button class="my-btn btn-right">Contact</button></a>
      </div>
    </nav>
    <div class="catalog-menu">
        <div class="content-menu">
            <div class="left-column">
                <h2>MEN</h2>
                <a href="catalogue.php?filter=tshirts">T-shirts</a>
                <a href="catalogue.php?filter=sneakers">Sneakers</a>
                <a href="catalogue.php?filter=footwear">Accessory </a>
                <div class="btns">
                    <a href="catalogue.php?filter=bag">bags</a>
                    <a href="catalogue.php?filter=socks">socks</a>
                </div>
            </div>
            <div class="right-column">
                <h2>WOMEN</h2>
                <a href="catalogue.php?filter=tshirts">T-shirts</a>
                <a href="catalogue.php?filter=sneakers">Sneakers</a>
                <a href="catalogue.php?filter=footwear">Accessory </a>
                <div class="btns">
                    <a href="catalogue.php?filter=bag">bags</a>
                    <a href="catalogue.php?filter=socks">socks</a>
                </div>
            </div>
        </div>
      <div class="endBtn">
          <a href="/vogueVibes_New/frontend/pages/catalogue.php">shop all</a>
      </div>
    </div>
            <div class="menu">
              <?php 
              if (!empty($_SESSION['cart'])) {
                echo '<a href="../pages/basket.php"><i class="fa fa-cart-shopping fa-bounce"></i></a>';
            } else {
                echo '<a href="../pages/basket.php"><i class="fa fa-cart-shopping"></i></a>';
            }
              ?>
              <a href="../pages/helpPage.php"><i class="fa-solid fa-pen-to-square"></i></a>
              <a href="../pages/profile.php"><i class="fa-regular fa-heart"></i></a>
              <a href="../../backend/logout.php"><i class="fa fa-right-from-bracket"></i></a>
          </div>
        </div>
      </div>
  </nav>
   <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
   <?php
if (isset($_SESSION["username"]) && ($_SESSION["role"]) == 1) {
  echo "<script>window.location.href='../../admin/admin.php'</script>";
  exit();
}
?>
  <?php }else if(!isset($_SESSION["username"])){ ?>
    <nav class="my-navbar">
      <div class="left-half">
        <button class="my-btn btn-left">Catalog</button>
      </div>
     <a href="../pages/index.php"> <div class="logo"><img src="/vogueVibes_New/frontend/img/workpieces/LOGO.png"></div></a>
      <div class="right-half">
        <a href="../pages/aboutus.php"><button class="my-btn btn-right">Contact</button></a>
      </div>
    </nav>
    <div class="catalog-menu">
        <div class="content-menu">
            <div class="left-column">
                <h2>MEN</h2>
                <a href="catalogue.php?filter=tshirts">T-shirts</a>
                <a href="catalogue.php?filter=sneakers">Sneakers</a>
                <a href="catalogue.php?filter=footwear">Accessory </a>
                <div class="btns">
                    <a href="catalogue.php?filter=bag">bags</a>
                    <a href="catalogue.php?filter=socks">socks</a>
                </div>
            </div>
            <div class="right-column">
                <h2>WOMEN</h2>
                <a href="catalogue.php?filter=tshirts">T-shirts</a>
                <a href="catalogue.php?filter=sneakers">Sneakers</a>
                <a href="catalogue.php?filter=footwear">Accessory </a>
                <div class="btns">
                    <a href="catalogue.php?filter=bag">bags</a>
                    <a href="catalogue.php?filter=socks">socks</a>
                </div>
            </div>
        </div>
      <div class="endBtn">
          <a href="/vogueVibes_New/frontend/pages/catalogue.php">shop all</a>
      </div>
    </div>
    <div class="menu">
      <a href="../pages/login.php"><i class="fa fa-user"></i></a>
      <a href="#"><i class="fa-regular fa-heart"></i></a>
    </div>
          <?php
              }
          ?>          

</header>