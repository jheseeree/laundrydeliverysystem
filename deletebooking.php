<?php
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "laundry_delivery";

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// sql to delete a record
$sql = "DELETE FROM booking WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header('Location: /awebdes_finals/dashboard-admin.php');
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>