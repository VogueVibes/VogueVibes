<?php
// Include necessary files and database connection
include_once __DIR__ . '/../config/conn.php';
include_once __DIR__ . '/../frontend/components/materials.php';

if (isset($_POST['offset'])) {
    $limit = 3; // Number of items to fetch per request
    $offset = (int)$_POST['offset'];
    $filter = isset($_POST['filter']) ? mysqli_real_escape_string($conn, $_POST['filter']) : '';

    // SQL query to fetch products with optional filter
    $sql = "SELECT * FROM `produkte` WHERE category = 'regular'";
    if ($filter) {
        $sql .= " AND typeName = '$filter'";
    }
    $sql .= " LIMIT $offset, $limit";
    $cards = mysqli_query($conn, $sql);

    if (!$cards) {
        // Log and display any SQL errors
        echo "SQL Error: " . mysqli_error($conn);
        exit();
    }

    $html = '';
    while ($good = mysqli_fetch_assoc($cards)) {
        // Generate card HTML using the function from materials.php
        $html .= generateCardHTML($good);
    }

    echo $html;
    exit();
}

// If it's a normal page load, fetch the initial cards
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : '';

// SQL query to fetch initial products
$sql = "SELECT * FROM `produkte` WHERE category = 'regular'";
if ($filter) {
    $sql .= " AND typeName = '$filter'";
}
$sql .= " LIMIT 6";
$cards = mysqli_query($conn, $sql);

if (!$cards) {
    // Log and display any SQL errors
    echo "SQL Error: " . mysqli_error($conn);
    exit();
}
?>
