<?php
session_start();
include "../components/header.php";
include "../components/navbar.php";
include "../../backend/cards.php";

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Build the SQL query based on the filter
$sql = "SELECT * FROM produkte";
if ($filter) {
    $sql .= " WHERE typeName = '" . mysqli_real_escape_string($conn, $filter) . "' AND category = 'regular'";
} else {
    // Exclude items with category 'brand' when no specific filter is applied
    $sql .= " WHERE category != 'brand'";
}
$sql .= " LIMIT 6";

$result = mysqli_query($conn, $sql);
?>
<body class="AllContent">
<section class='log-seite'>
<div class="row">
<?php 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Generate card HTML using the function from card_template.php
        echo generateCardHTML($row);
    }
} else {
    echo "No products found.";
}
?>
    </div>
    <button class="morebtn" onclick="send()">More</button>
</section> 

<?php
include "../components/footer.php";
?>
<script src="../JS/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
let offset = 6; // Starting offset for loading more cards
let filter = new URLSearchParams(window.location.search).get('filter') || '';

function send() {
    $.ajax({
        type: "POST",
        url: "/vogueVibes_New/backend/cards.php",
        data: { offset: offset, filter: filter },
        success: function (data) {
            $(".row").append(data);
            offset += 6; // Increment the offset for the next query
        },
        error: function () {
            alert("Failed to load more cards.");
        }
    });
}

$(document).ready(function() {
    // Use event delegation to bind the event handler to the parent container "row"
    $('.row').on('submit', '#form-submit', function(e) {
        e.preventDefault(); // Prevent the default form submission behavior

        var formData = $(this).serialize(); // Get the form data for the clicked form

        // Perform the AJAX request
        $.ajax({
            type: 'POST',
            url: "/vogueVibes_New/backend/add_basket_card.php",
            data: formData,
            success: function(response) {
                console.log('Successfully added to basket!');
                console.log(formData);
            },
            error: function(xhr, status, error) {
                console.error('Error adding to basket:', error);
            }
        });
    });
});
</script>
</body>
</html>
