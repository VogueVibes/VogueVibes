<?php
// Include necessary files and database connection
include_once __DIR__ . '/../config/conn.php';
include_once __DIR__ . '/../frontend/components/materials.php';


if (isset($_POST['offset'])) {
    $limit = 3;
    $offset = (int)$_POST['offset'];
    $filter = isset($_POST['filter']) ? mysqli_real_escape_string($conn, $_POST['filter']) : '';

    // Modified SQL query to include the filter
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
// Get the filter from the URL, if any
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : '';

// Modified SQL to fetch only regular items initially
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
