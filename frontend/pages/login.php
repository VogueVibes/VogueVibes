<?php
include "../../backend/login.php";
include "../components/header.php";
include "../components/navbar.php";
// include "../../backend/check_status.php";
?>


<body>
<section class="grund">
    <div class="container col">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="sign-in-form">
            <div>
            <h1 class="text-center text-muted ">LOGINFORM</h1>
            </div>
            <br>
            <div class="text"> Don't have an account? <a href="../pages/registrierung.php" style="color:#c9a58b;"> Register</a></div>
    
            <div class="form-group mb-3">
                <!-- <label>Логин:</label> -->
                <input type="text" class="form-control" id="email" placeholder="Login" value="<?PHP if (!empty($_POST["username"])) {
    echo $_POST["username"];
}?>" name="username" required>

            </div>
        
            <div class="form-group mb-3">
                <!-- <label>Пароль:</label> -->
                <input type="password" class="form-control" id="password" placeholder="Password" value="<?PHP if (!empty($_POST["password"])) {
    echo $_POST["password"];
}?>" name="password" required>
            </div>
            <div class="error" style="color: red; text-align: center;padding:10px">
         <?php
if (isset($_GET['error'])) {
    echo $_GET['error'];
}
?>
        </div>

            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-login">Login</button>
            </div>        
        </form>
    </div>
 </section>
    <?php
include "../components/footer.php";
?>
</body>
    <script src="../JS/script.js"></script>