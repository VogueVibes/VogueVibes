<?php
session_start();
include_once "../config/conn.php";

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Получаем текущий статус пользователя из базы данных
    $query = "SELECT status FROM user WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentStatus = $row['status'];

        // Проверяем статус пользователя
        if ($currentStatus == 'Inactive') {
            // Если статус неактивен, перенаправляем пользователя или выполняем другие действия
            // например, выход пользователя из аккаунта или отображение сообщения об ошибке.
            // Ниже пример перенаправления на страницу выхода.
            header("Location: logout.php");
            exit();
        }
    }
}

// Закрываем соединение с базой данных
mysqli_close($conn);
?>
