<?php
session_start();
include "../components/header.php"; // Include header component
include "../components/navbar.php"; // Include navbar component
include "../../backend/register.php"; // Include register backend script
?>

<head>
    <!-- Bootstrap CSS -->
    <link href="/docs/5.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
      /* General styles */
      body {
          background: #ddc8bf;
      }
      .form-control {
          background: #ddc8bf;
          border: white 3px solid;
      }
      .error-message {
          color: red;
          font-size: 0.875em;
      }
      .valid-feedback {
          display: none;
          color: green;
          font-size: 0.875em;
      }
      .is-valid ~ .valid-feedback {
          display: block;
      }
      .is-invalid ~ .error-message {
          display: block;
      }
      .is-invalid {
          border-color: red;
      }
      .is-valid {
          border-color: green;
      }
      a {
          text-decoration: none;
      }
      a:hover {
          color: white;
      }
    </style>
</head>
<body class="AllContent">
    <section class="registr">
        <div class="container col">
            <!-- Registration form -->
            <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="row g-3 needs-validation" novalidate>
                <h1 class="text-center text-muted">User Sign Up</h1>
                <br>
                <div class="text">Already a user? <a href="login.php" style="color:#c9a58b">LOGIN</a></div>
                <hr>
                <!-- Form fields for registration -->
                <div class="form-group">
                    <label for="validationCustom01">Anrede:</label>
                    <select class="form-control" id="validationCustom01" name="anrede" style="background: #ddc8bf;" required>
                        <option value="" disabled selected>Please select</option>
                        <option>Mr</option>
                        <option>Mrs</option>
                        <option>Other</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select an alternative!
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <!-- First name field -->
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">First Name</label>
                    <input type="text" class="form-control" style="background: #ddc8bf;" value="<?php echo htmlspecialchars($firstname ?? ''); ?>" id="validationCustom02" placeholder="First name" name="firstname" required>
                    <div class="invalid-feedback">
                        Please write your first name!
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <!-- Last name field -->
                <div class="col-md-6">
                    <label for="validationCustom03" class="form-label">Last Name</label>
                    <input type="text" class="form-control" style="background: #ddc8bf;" value="<?php echo htmlspecialchars($lastname ?? ''); ?>" id="validationCustom03" placeholder="Last name" name="lastname" required>
                    <div class="invalid-feedback">
                        Please write your last name!
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <!-- Email field -->
                <div class="col-md-6">
                    <label for="validationCustom04" class="form-label">Email</label>
                    <input type="email" class="form-control" style="background: #ddc8bf;" value="<?php echo htmlspecialchars($email ?? ''); ?>" id="validationCustom04" placeholder="example@gmail.com" name="email" required>
                    <div class="invalid-feedback" id="email-feedback">
                        Please write your E-mail!
                    </div>
                    <div id="email-error" class="error-message"></div>
                    <div id="email-valid" class="valid-feedback">
                        Email is available!
                    </div>
                </div>
                <!-- Username field -->
                <div class="col-md-6">
                    <label for="validationCustom05" class="form-label">User Name</label>
                    <input type="text" style="background: #ddc8bf;" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>" id="validationCustom05" placeholder="User name" name="username" required>
                    <div class="invalid-feedback" id="username-feedback">
                        Please write a username!
                    </div>
                    <div id="username-error" class="error-message"></div>
                    <div id="username-valid" class="valid-feedback">
                        Username is available!
                    </div>
                </div>
                <!-- Password field -->
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Password</label>
                    <input type="password" class="form-control" style="background: #ddc8bf;" id="inputPassword4" placeholder="Password" name="password" required>
                    <div id="password-error" class="error-message"></div>
                    <div class="valid-feedback">
                        Password is strong!
                    </div>
                </div>
                <!-- Repeat password field -->
                <div class="col-md-6">
                    <label for="inputRepeatPassword4" class="form-label">Repeat Password</label>
                    <input type="password" class="form-control" style="background: #ddc8bf;" id="inputRepeatPassword4" placeholder="Repeat password" name="pwdconfirm" required>
                    <div class="invalid-feedback">
                        Please rewrite your password!
                    </div>
                    <div class="valid-feedback">
                        Passwords match!
                    </div>
                </div>
                <!-- Submit button -->
                <div class="d-grid gap-2">
                    <button type="submit" id="submitButton" name="submit" class="my-btn btn-sigup" value="Submit" disabled>Sign Up</button>
                </div>
            </form>
        </div>
    </section>
    <?php include "../components/footer.php"; // Include footer component ?>
</body>

<!-- JavaScript for form validation and AJAX checks -->
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var form = document.getElementById('registrationForm');
    var emailInput = document.getElementById('validationCustom04');
    var usernameInput = document.getElementById('validationCustom05');
    var passwordInput = document.getElementById('inputPassword4');
    var confirmPasswordInput = document.getElementById('inputRepeatPassword4');
    var submitButton = document.getElementById('submitButton');
    var emailError = document.getElementById('email-error');
    var emailFeedback = document.getElementById('email-feedback');
    var emailValid = document.getElementById('email-valid');
    var usernameError = document.getElementById('username-error');
    var usernameFeedback = document.getElementById('username-feedback');
    var usernameValid = document.getElementById('username-valid');
    var passwordError = document.getElementById('password-error');

    // Function to validate form fields
    var validateField = function(input) {
      if (input.checkValidity()) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
      } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
      }
    };

    var inputs = document.querySelectorAll('input, select');
    inputs.forEach(function(input) {
      input.addEventListener('input', function() {
        validateField(input);
        toggleSubmitButton();
      });
    });

    // Check email uniqueness
    emailInput.addEventListener('blur', function() {
      var email = emailInput.value;
      if (email) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/services/check_email.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            if (xhr.responseText === 'Email is already in use!') {
              emailInput.classList.remove('is-valid');
              emailInput.classList.add('is-invalid');
              emailError.textContent = xhr.responseText;
              emailValid.style.display = 'none';
              emailFeedback.style.display = 'none';
              toggleSubmitButton();
            } else {
              emailInput.classList.remove('is-invalid');
              emailInput.classList.add('is-valid');
              emailError.textContent = '';
              emailValid.style.display = 'block';
              emailFeedback.style.display = 'none';
              toggleSubmitButton();
            }
          }
        };
        xhr.send('email=' + encodeURIComponent(email));
      }
    });

    // Check username uniqueness
    usernameInput.addEventListener('blur', function() {
      var username = usernameInput.value;
      if (username) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../backend/services/check_username.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            if (xhr.responseText === 'Username is already in use!') {
              usernameInput.classList.remove('is-valid');
              usernameInput.classList.add('is-invalid');
              usernameError.textContent = xhr.responseText;
              usernameValid.style.display = 'none';
              usernameFeedback.style.display = 'none';
              toggleSubmitButton();
            } else {
              usernameInput.classList.remove('is-invalid');
              usernameInput.classList.add('is-valid');
              usernameError.textContent = '';
              usernameValid.style.display = 'block';
              usernameFeedback.style.display = 'none';
              toggleSubmitButton();
            }
          }
        };
        xhr.send('username=' + encodeURIComponent(username));
      }
    });

    // Check password strength and match
    passwordInput.addEventListener('input', function() {
      if (passwordInput.value.length === 0) {
        passwordInput.setCustomValidity('Please enter a password');
        passwordError.textContent = 'Please enter a password';
      } else if (passwordInput.value.length < 8) {
        passwordInput.setCustomValidity('Password is too short, please enter at least 8 characters');
        passwordError.textContent = 'Password is too short, please enter at least 8 characters';
      } else {
        passwordInput.setCustomValidity('');
        passwordError.textContent = '';
      }
      validateField(passwordInput);
      toggleSubmitButton();
    });

    confirmPasswordInput.addEventListener('input', function() {
      if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.setCustomValidity('Passwords do not match');
      } else {
        confirmPasswordInput.setCustomValidity('');
      }
      validateField(confirmPasswordInput);
      toggleSubmitButton();
    });

    // Toggle submit button
    function toggleSubmitButton() {
      if (form.checkValidity() && emailInput.classList.contains('is-valid') && usernameInput.classList.contains('is-valid')) {
        submitButton.disabled = false;
      } else {
        submitButton.disabled = true;
      }
    }

    // Prevent form submission if fields are invalid
    form.addEventListener('submit', function(event) {
      inputs.forEach(function(input) {
        validateField(input);
      });
      if (form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    });
  }, false);
})();
</script>
<script src="../JS/script.js"></script> <!-- Include main JavaScript file -->
