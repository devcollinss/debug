<?php
include "../connection.php";
include "../auth.php";
// $_SESSION['msg'] = '';
function select_data($instruction) {

$instruction = $_POST['instruction'];

$query = "SELECT $instruction";
$result = $link->query($query);

if (!$result) {
  die("Failed to execute SELECT statement: " . mysqli_error($link));
}

// Initialize an array to store the data
$data = [];

// Add the data to the array
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

// Return the data as a JSON encoded string
echo json_encode($data);

// Close the MySQL connection
mysqli_close($link);
}