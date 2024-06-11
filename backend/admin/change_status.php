<?php
include "../../config/conn.php";

if (isset($_POST['id'])) {
  $userId = $_POST['id'];
  
  // Получение текущего статуса пользователя из базы данных
  $query = "SELECT status FROM user WHERE id = '$userId'";
  $result = mysqli_query($conn, $query);
  
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $currentStatus = $row['status'];
    
    // Изменение статуса на противоположный
    $newStatus = ($currentStatus == 'Active') ? 'Inactive' : 'Active';
    
    // Выполнение запроса на изменение статуса пользователя в базе данных
    $updateQuery = "UPDATE user SET status = '$newStatus' WHERE id = '$userId'";
    $updateResult = mysqli_query($conn, $updateQuery);
    
    if ($updateResult) {
      echo $newStatus; // Отправка нового статуса в ответе
    } else {
      echo 'error';
    }
  } else {
    echo 'error';
  }
} else {
  echo 'error';
}

// Закрытие соединения с базой данных
mysqli_close($conn);
?>
