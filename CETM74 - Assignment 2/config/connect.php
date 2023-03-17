<?php
$servername = "localhost:3306";
$username = "wearview_db";
$password = "0ey6wS$2";
$database = "admin_wearview";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>