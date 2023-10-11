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
    <link rel="stylesheet" href="css/indexcss2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">




    <title>Officer</title>
</head>

<body>
    <?php
    $sql = "SELECT COUNT(HN) AS total_approve FROM book WHERE Status = 'รออนุมัติ'";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalApporve = $row['total_approve'];

    $sql = "SELECT SUM(rt_num) AS total_rooms FROM room_type";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalRooms = $row['total_rooms'];


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
            <div class="texth1">
                <h1> ยินดีต้อนรับ </h1>
            </div>

            <div class="box1">
                <div class="box2">
                    <img src="/code/backend/images/bed.png">
                    <div class="textbox2">


                        <div class="textr">
                            <h2> <?php echo $totalRooms; ?> </h2>
                        </div>


                        <div class="texta">
                            <a> จำนวนห้องว่าง </a>
                        </div>

                    </div>
                </div>


                <div class="box4">
                    <img src="/code/backend/images/booking.png">
                    <div class="textbox2">
                        <div class="textr">
                            <h2> <?php echo $totalApporve; ?> </h2>
                        </div>
                        <div class="texta">
                            <a> รออนุมัติ </a>
                        </div>


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
                    <a class="nav-link" href="officer_room.php"> ห้องพักผู้ป่วย </a>
                </li>
                <!--<li class="nav-item">
                <a class="nav-link" href="officer_nroom.php"> สถานะห้องพัก </a>
            </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="officer_approve.php"> ข้อมูลการจอง </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="officer_history.php"> ประวัติการจอง </a>
                </li>
                <div class="boxout">
                    <div class="endout">
                        <li class="nav-item">
                            <a class="nav-link" href="officer_profile.php"> เเก้ไขโปรไฟล์ </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_page.php"> ออกจากระบบ </a>
                        </li>
                    </div>
                </div>
            </ul>
        </nav>

</body>

</html>