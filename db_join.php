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

    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง 'register' เมื่อ HN ตรงกัน
    $sql = "SELECT ID_number, S_name, Department FROM register WHERE HN = '$HN'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = [
            'found' => true,
            'ID_number' => $row['ID_number'],
            'S_name' => $row['S_name'],
            'Department' => $row['Department']
        ];
        echo json_encode($data);
    } else {
        // ไม่พบข้อมูลสำหรับ HN ที่ระบุ
        $data = [
            'found' => false
        ];
        echo json_encode($data);
    }
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
