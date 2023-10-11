<?php

require_once('dbcon.php');


// ตรวจสอบว่ามีการส่งข้อมูลโดยใช้ POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HN = $_POST['HN'];
    $ID_number = $_POST['ID_number'];
    $S_name = $_POST['S_name'];
    $P_number = $_POST['P_number'];
    $Email = $_POST['Email'];



    // รับค่า HN จากฟอร์ม
    $hn = $_POST['HN'];



    // คำสั่ง SQL เพื่อตรวจสอบการจอง
    $sql = "SELECT * FROM register WHERE HN = '$hn'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // ถ้ามีการจองห้องพักอยู่แล้ว
        $message = "HN $hn เคยทำการลงทะเบียนแล้ว";
        echo "<script>alert('".$message."')</script>";
        echo "<script>window.location.href='register.php'</script>";
    } else {


    // เพิ่มข้อมูลลงในตาราง "register"
    $sql = "INSERT INTO register (HN, ID_number, S_name ,P_number, Email) VALUES ('$HN', '$ID_number', '$S_name','$P_number', '$Email')";

    if ($conn->query($sql) === TRUE) {
        $messagetrue1 = "ลงทะเบียนสำเร็จ";
        echo "<script>alert('" . $messagetrue1 . "')</script>";
        echo "<script>window.location.href='main.php'</script>";
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: ";
    }
}
}