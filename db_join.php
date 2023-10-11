<?php
require_once('dbcon.php');


// ตรวจสอบว่ามีการส่งข้อมูลโดยใช้ POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HN = $_POST['HN'];

    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง 'register' เมื่อ HN ตรงกัน
    $sql = "SELECT ID_number, S_name FROM register WHERE HN = '$HN'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = [
            'found' => true,
            'ID_number' => $row['ID_number'],
            'S_name' => $row['S_name'],
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