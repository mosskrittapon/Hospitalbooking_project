<?php
session_start();
require_once('db.php');
if (!isset($_SESSION['admin_login'])) {
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

    <title>Admin Index</title>
</head>

<body>
    <?php
    // คำสั่ง SQL เพื่อนับจำนวน ID ในตาราง member
    $sql = "SELECT COUNT(m_id) AS total_member FROM member";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalMembers = $row['total_member'];

    // เมื่อ login เข้ามาเเล้วให้นำข้อมูลของตาราง member จาก Database มาใช้งานในหน้าเว็บ 
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * FROM member WHERE m_id = $admin_id");
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
                    <img src="/code/backend/images/bed.png">
                    <div class="textbox2">


                        <div class="textr">
                            <h2> <?php echo $totalMembers; ?> </h2>
                        </div>


                        <div class="texta">
                            <a> จำนวนเจ้าหน้าที่ </a>
                        </div>

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
                <a class="nav-link" href="admin_index.php"> หน้าหลัก </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_member.php"> จัดการเจ้าหน้าที่ </a>
            </li>
            <div class="boxout2">
                <li class="nav-item">
                    <a class="nav-link" href="login_page.php"> ออกจากระบบ </a>
                </li>
            </div>
        </ul>
    </nav>
</body>

</html>