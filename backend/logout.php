<?php 
session_start(); // Start the session
session_destroy(); // Destroy all session data
header("Location: /vogueVibes_New/frontend/pages/index.php"); // Redirect to the index page
exit(); // Ensure no further code is executed after the redirect
?>
