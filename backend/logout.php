<?php 
session_start();
session_destroy();
header("location:/vogueVibes_New/frontend/pages/index.php");
?>