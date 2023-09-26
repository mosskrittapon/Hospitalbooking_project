<?php
session_start();
require_once('db.php');
if (!isset($_SESSION['officer_login'])) {
    header('location: login_page.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- style link -->
    <link rel="stylesheet" href="css/indexcss.css">
    <title>Officer</title>
</head>

<body>
    <?php
    $sql = "SELECT COUNT(HN) AS total_approve FROM book";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalApporve = $row['total_approve'];

    $sql = "SELECT COUNT(rn_id) AS total_room FROM room_num";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalRoom = $row['total_room'];

    // เมื่อ login เข้ามาเเล้วให้นำข้อมูลของตาราง member จาก Database มาใช้งานในหน้าเว็บ 
    if (isset($_SESSION['officer_login'])) {
        $officer_id = $_SESSION['officer_login'];
        $stmt = $conn->query("SELECT * FROM member WHERE m_id = $officer_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    include("navbar.php")
    ?>

    <div class="container">
        <div class="row">
            <h1> ยินดีต้อนรับ </h1>
            <div class="box1">
                <div class="box2">
                    <img src="/thesis2/images/bed.png" width="140" height="140">
                    <div class="textbox2">
                        <h2> <?php echo $totalRoom; ?> </h2>
                        <a> จำนวนห้องว่าง </a>
                    </div>
                </div>
            </div>
            <div class="box3">
                <div class="box4">
                    <img src="/thesis2/images/booking.png" width="130" height="130">
                    <div class="textbox1">
                        <h2> <?php echo $totalApporve; ?> </h2>
                        <a> รออนุมัติ </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- menu_left -->
        <nav class="sidebar">
            <ul class="nav flex-column">
                <hr>
                <div class="ad-name">
                    <h1> <?php echo  $row['m_firstname'] . ' ' . $row['m_lastname'] ?> </h1>
                </div>
                <hr>
                <li class="nav-item">
                    <a class="nav-link" href="officer_index.php"> หน้าหลัก </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="officer_department.php"> แผนกผู้ป่วย </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="officer_room.php"> ประเภทห้องพัก </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="officer_nroom.php"> จำนวนห้องพัก </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="officer_approve.php"> อนุมัติการจอง </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_page.php"> ออกจากระบบ </a>
                </li>
            </ul>
        </nav>

</body>

</html>