<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหล่า: " . $conn->connect_error);
}



// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HN = $_POST["HN"];
    $P_number = $_POST["P_number"];

        $sql = "SELECT * FROM book WHERE HN = '$HN' AND P_number = '$P_number'";
        $result = $conn->query($sql);

        if (mysqli_num_rows($result) > 0) {

            // เรียกใช้คำสั่ง SQL เพื่อลบ attribute
            $sql = "DELETE FROM book WHERE HN = '$HN' AND P_number = '$P_number'";
            $conn->query($sql);
        
            // แสดงข้อความแจ้งว่าลบ attribute สำเร็จ
            echo "<script>alert('ยกเลิกจองห้องพักสำเร็จ');</script>";
        } else {
            echo "<script>alert('กรุณาตรวจสอบความถูกต้องว่า HN และ เบอร์โทรศัพท์ผู้จอง ถูกต้องหรือไม่');</script>";
        }

        


}    







   // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
?>
