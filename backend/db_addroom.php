<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีข้อมูล POST ที่ถูกส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_name = $_POST["room_name"];
    $room_price = $_POST["room_price"];
    $availability = $_POST["availability"];

    // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลห้องพัก
    $sql = "INSERT INTO room (room_name, room_price, availability) VALUES ('$room_name', $room_price, $availability)";

    if ($conn->query($sql) === TRUE) {
        echo "เพิ่มห้องพักใหม่เรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มห้องพัก: " . $conn->error;
    }
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
