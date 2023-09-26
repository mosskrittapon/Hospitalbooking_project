<?php

require_once('dbcon.php');


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
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: ";
    }
}
