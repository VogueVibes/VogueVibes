<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



// Проверяем, был ли отправлен идентификатор карточки для удаления
if (isset($_POST['cardId'])) {
    $cardId = $_POST['cardId'];


    // Подключаемся к базе данных
    include "../config/conn.php";
    // Подготавливаем и выполняем SQL-запрос для удаления записи
    $query = "DELETE FROM `basket` WHERE id = $cardId";
    $result = mysqli_query($conn, $query);

    // Проверяем, было ли успешно выполнение запроса
    if ($result) {
        // Успешно удалено
        $response = array('statusCode' => 200, 'message' => 'Card deleted successfully.');
    } else {
        // Ошибка при удалении
        $response = array('statusCode' => 500, 'message' => 'Failed to delete the card.');
    }

    // Возвращаем JSON-ответ
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); // Важно завершить выполнение скрипта после отправки JSON-ответа
}





?>