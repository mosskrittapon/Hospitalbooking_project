<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>