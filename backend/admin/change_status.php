<?php
include "../../config/conn.php";

if (isset($_POST['id'])) {
  $userId = $_POST['id'];
  
  // Get the current status of the user from the database
  $query = "SELECT status FROM user WHERE id = '$userId'";
  $result = mysqli_query($conn, $query);
  
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $currentStatus = $row['status'];
    
    // Change the status to the opposite
    $newStatus = ($currentStatus == 'Active') ? 'Inactive' : 'Active';
    
    // Execute the query to change the user's status in the database
    $updateQuery = "UPDATE user SET status = '$newStatus' WHERE id = '$userId'";
    $updateResult = mysqli_query($conn, $updateQuery);
    
    if ($updateResult) {
      echo 'success'; // Ensure this is exactly 'success'
    } else {
      echo 'error';
    }
  } else {
    echo 'error';
  }
} else {
  echo 'error';
}

// Close the database connection
mysqli_close($conn);
?>
