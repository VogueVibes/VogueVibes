<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="CSS/uploaderCards.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <style>
        /* General styles for the body and background */
        body {
            background: #ddc8bf;
        }

        .grund {
            background: #ddc8bf;
        }

        ::placeholder {
            color: #fff;
        }

        /* Container styles */
        .grund .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
            height: auto;
            margin-top: 100px;
            border: white 3px solid;
            border-radius: 5px;
        }

        /* Form styles */
        .grund .sign-in-form {
            color: white;
            border-radius: 5px;
            padding: 20px;
        }

        .grund .text {
            text-align: center;
            color: white;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .grund .form-group label {
            color: white;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .grund .form-control {
            background: #ddc8bf;
            border: solid 3px white;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .grund .form-control:focus {
            border-color: #c9a58b;
            outline: none;
        }

        .grund .btn-login {
            background-color: #5A4467;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            width: 150px;
        }

        .grund .btn-login:hover {
            background-color: #473552;
        }

        /* Responsive styles */
        @media (max-width: 600px) {
            .grund .container {
                padding: 10px;
                width: 100%;
            }

            .grund .sign-in-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php
include "../../backend/login.php"; // Include login backend script
include "../components/header.php"; // Include header component
include "../components/navbar.php"; // Include navbar component
?>
<section class="grund">
    <div class="container col">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="sign-in-form">
            <div>
                <h1 class="text-center text-muted">LOGINFORM</h1>
            </div>
            <br>
            <div class="text"> Don't have an account? <a href="../pages/registrierung.php" style="color:#c9a58b;"> Register</a></div>
    
            <!-- Input for username -->
            <div class="form-group mb-3">
                <input type="text" class="form-control" id="email" placeholder="Login" value="<?php if (!empty($_POST["username"])) { echo $_POST["username"]; } ?>" name="username" required>
            </div>
        
            <!-- Input for password -->
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password" value="<?php if (!empty($_POST["password"])) { echo $_POST["password"]; } ?>" name="password" required>
            </div>

            <!-- Error message display -->
            <div class="error" style="color: red; text-align: center; padding: 10px;">
                <?php if (isset($_GET['error'])) { echo $_GET['error']; } ?>
            </div>

            <!-- Submit button -->
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-login">Login</button>
            </div>        
        </form>
    </div>
</section>
<?php
include "../components/footer.php"; // Include footer component
?>
<script src="../JS/script.js"></script> <!-- Include main JavaScript file -->
</body>
