<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งข้อมูลโดยใช้ POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HN = $_POST['HN'];
    $ID_number = $_POST['ID_number'];
    $S_name = $_POST['S_name'];
    $Department = $_POST['Department'];
    $P_number = $_POST['P_number'];
    $Email = $_POST['Email'];

    // เพิ่มข้อมูลลงในตาราง "register"
    $sql = "INSERT INTO register (HN, ID_number, S_name, Department,P_number, Email) VALUES ('$HN', '$ID_number', '$S_name', '$Department','$P_number', '$Email')";

    if ($conn->query($sql) === TRUE) {
        header("Location: main.php"); // เปลี่ยนทิศทางไปยัง confirm.php
        exit(); 
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
