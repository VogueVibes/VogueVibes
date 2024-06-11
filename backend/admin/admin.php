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
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                    <i class="uil uil-user-circle"></i>
                        <span class="text">Total Users</span>
                        <span class="number"><?php echo $totalUsers; ?></span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-book-medical"></i>
                        <span class="text">Total Products</span>
                        <span class="number"><?php echo $totalProducts;?></span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-shopping-bag"></i>
                        <span class="text">Total Orders</span>
                        <span class="number">10,120</span>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Activity</span>
                </div>
                <div class="activity-data">
                    <div class="data id">
                        <span class="data-title">ID</span>
                        <?php 
                        // Возвращение указателя результата в начало
                        mysqli_data_seek($result, 0);
                        
                        // Проверка наличия данных и вывод их в HTML-код
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['id'] . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <div class="data names">
                        <span class="data-title">Name</span>
                        <?php 
                        // Возвращение указателя результата в начало
                        mysqli_data_seek($result, 0);
                        
                        // Проверка наличия данных и вывод их в HTML-код
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['firstname'] . '</span>';
                            }
                        }
                        ?>
                    </div>
                    
                    <div class="data email">
                        <span class="data-title">Email</span>
                        <?php 
                        // Возвращение указателя результата в начало
                        mysqli_data_seek($result, 0);
                        
                        // Проверка наличия данных и вывод их в HTML-код
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['email'] . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <!-- <div class="data type">
                        <span class="data-title">Type</span>
                        <?php 
                        // Возвращение указателя результата в начало
                        mysqli_data_seek($result, 0);
                        
                        // Проверка наличия данных и вывод их в HTML-код
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<span class="data-list">' . $row['type'] . '</span>';
                            }
                        }
                        ?>
                    </div> -->
                    <div class="data status">
                        <span class="data-title">Status</span>
                        <?php 
                        // Возвращение указателя результата в начало
                        mysqli_data_seek($result, 0);
                        
                        // Проверка наличия данных и вывод их в HTML-код
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="data-list">';
                                echo '<span>' . $row['status'] . '</span>';
                                echo '<button class="status-btn" data-id="' . $row['id'] . '"><i class="uil uil-ban"></i></button>';
                                echo '</div>';
                            }
                        }
                        ?>
                </div>
            </div>
        </div>
    </section>
    <?php 
    // Закрытие соединения с базой данных
    mysqli_close($conn);
    ?>

    <script src="JS/admin.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('.status-btn').click(function() {
    var userId = $(this).data('id');
    
    // Отправка AJAX-запроса на сервер для изменения статуса пользователя
    $.ajax({
      url: 'change_status.php'
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
