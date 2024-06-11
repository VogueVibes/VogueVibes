<!DOCTYPE html>
<html lang = "en">
	<head>
		<title>Vindobona</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../../res/CSS/fileupload.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel = "stylesheet" type = "text/css" href = "CSS/uploaderCards.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
	</head>
<body>

<?php
include "../../config/conn.php";
if (!$conn) {
    die('Ошибка соединения с базой данных: ' . mysqli_connect_error());
}

// Выполнение запроса на выборку всех столбцов из таблицы user
$query = "SELECT * FROM user";
$result = mysqli_query($conn, $query);
$totalUsers = mysqli_num_rows($result);

$queryProducts = "SELECT * FROM produkte";
$resultProducts = mysqli_query($conn, $queryProducts);
$totalProducts = mysqli_num_rows($resultProducts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="CSS/admin.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard Panel</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="../../img/newlogo.png" alt="">
            </div>
            <span class="logo_name">VogueVibes</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="add_card.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li>
                <li><a href="adminbasket.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>
                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>
            <?php 
include_once "../../config/conn.php";

if (isset($_GET['error'])) : ?>
        <p><?php echo $_GET['error']; ?></p>
    <?php endif ?>
    <div class="container-fluid">
        <div class="wrapper" style=" height: 710px; border: solid gray 1px;">
            <header>File Uploader</header>
            <form method="POST" action='uploadfile.php' enctype="multipart/form-data">
                <div class="form-group">
                    <label>News Type</label>
                    <select class="form-control" required="required" name="typeName">
                        <option value="">Wähle eine Option</option>
                        <option value="Welcome!!!">bag</option>
                        <option value="Work in progress on the server">sneakers</option>
                        <option value="Special offer">cloth</option>
                        <option value="Important information">accessories</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" size="200" class="form-control" name="itemName" />
                </div>
				<div class="form-group">
                    <label>Price</label>
                    <input type="text" size="200" class="form-control" name="itemPrice" />
                </div>
                <div class="form-group">
                    <label>News Info</label>
                    <input type="text" size="200" class="form-control" name="itemDescription" />
                </div>

                <div class="form-group">
                    <div class="fileadd">
                        <input class="file-input" required="required" type="file" name="itemImage" hidden>
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Browse File to Upload</p>
                    </div>
                </div>
                <br /> 
                <div class="form-group">
                    <button name="add_card" class="btn btn-info form-control">Save</button>
                </div>
            </form>
        </div>
    </div>
            </div>
        </div>
    </section>
    <?php 
    // Закрытие соединения с базой данных
    mysqli_close($conn);
    ?>

    <script src="JS/admin.js"></script>
     <script src="JS/upload.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('.status-btn').click(function() {
    var userId = $(this).data('id');
    
    // Отправка AJAX-запроса на сервер для изменения статуса пользователя
    $.ajax({
      url: 'change_status.php',
      method: 'POST',
      data: { id: userId },
      success: function(response) {
        // Обработка успешного ответа от сервера
        if (response === 'success') {
          alert('Статус пользователя успешно изменен.');
          location.reload(); // Перезагрузка страницы для обновления данных
        } else {
          alert('Ошибка при изменении статуса пользователя.');
        }
        window.location.reload();
      },
      error: function() {
        alert('Произошла ошибка при отправке запроса на сервер.');
      }
    });
  });
});
</script>
</body>
</html>
