
<?php
include_once '../../config/conn.php';

if (isset($_POST['add_card'])) {
    $typeName = (string)$_POST['typeName'];
    $itemName = (string)$_POST['itemName'];
    $itemPrice= (string)$_POST['itemPrice'];
    $itemDescription = (string)$_POST['itemDescription'];
    $itemImage = addslashes(file_get_contents($_FILES['itemImage']['tmp_name']));
    $photo_name = $_FILES['itemImage']['name'];
    
    // Получите временное имя файла на сервере
    $tmp_file = $_FILES['itemImage']['tmp_name'];

    // Переместите загруженный файл в папку назначения
    $destination = "../photo/" . $photo_name;
    move_uploaded_file($tmp_file, $destination);
    
    // Определите путь к файлу изображения
    $itemImage = $photo_name;

	// $query = "INSERT INTO `produkte` (`itemName`, `itemPrice`, `itemImage`, `itemDescription`, `typeName`) 
	// VALUES ($itemName, '0', '0', $itemDescription, $typeName)";

    $query = "
    INSERT INTO `produkte`(
        `itemName`,
        `itemPrice`,
        `itemImage`,
        `itemDescription`,
        `typeName`
    ) VALUES (
        '$itemName',
        '$itemPrice',
        '$itemImage',
        '$itemDescription',
        '$typeName'
    )
    ";

    $conn->query($query);

    header("location: admin.php");
    exit();
}
?>
