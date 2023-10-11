<?php
session_start();

require_once('db.php');

//อนุมัติการจอง
if (isset($_GET['approve'])) {
    $approve_HN = $_GET['approve'];

    // ดึงข้อมูลการจองที่ต้องการอัปเดต
    $selectstmt = $conn->prepare("SELECT * FROM book WHERE HN = ?");
    $selectstmt->bindParam(1, $approve_HN, PDO::PARAM_STR);
    $selectstmt->execute();
    $result = $selectstmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $newStatus = $result['Status'] == 'อนุมัติ' ? 'รออนุมัติ' : 'อนุมัติ';

        // อัปเดตสถานะการจอง
        $approvetmt = $conn->prepare("UPDATE book SET status = :newStatus WHERE HN = :approveHN");
        $approvetmt->bindParam(':newStatus', $newStatus);
        $approvetmt->bindParam(':approveHN', $approve_HN);
        $approvetmt->execute();

        // ดึงข้อมูลจำนวนห้องว่างในตาราง room_type สำหรับห้องพักที่ถูกจอง
        $selectRoomStmt = $conn->prepare("SELECT rt_num FROM room_type WHERE rt_type = :rt_type");
        $selectRoomStmt->bindParam(':rt_type', $result['room']);
        $selectRoomStmt->execute();
        $roomData = $selectRoomStmt->fetch(PDO::FETCH_ASSOC);
        $rt_num = $roomData['rt_num'];

        // ตรวจสอบสถานะเพื่อลดหรือเพิ่ม rt_num ตามที่คุณต้องการ
        if ($newStatus == 'อนุมัติ') {
            $rt_num--; // ลดจำนวนห้องว่างลง 1
        } elseif ($newStatus == 'รออนุมัติ') {
            $rt_num++; // เพิ่มจำนวนห้องว่างขึ้น 1
        }



        // ทำการอัปเดตจำนวนห้องว่างในฐานข้อมูลห้องพัก
        $updateRoomStmt = $conn->prepare("UPDATE room_type SET rt_num = :rt_num WHERE rt_type = :rt_type");
        $updateRoomStmt->bindParam(':rt_num', $rt_num);
        $updateRoomStmt->bindParam(':rt_type', $result['room']);
        $updateRoomStmt->execute();

        // ตรวจสอบความสำเร็จและเปลี่ยนเส้นทาง
        if ($approvetmt && $updateRoomStmt) {
            $_SESSION['success'] = "สถานะการจองถูกเปลี่ยนแปลงเรียบร้อยเเล้ว";
            header("refresh:2; url=officer_approve.php");
        }
    } else {
        echo "<script>alert('ไม่พบข้อมูล');</script>";
    }
}
//ยกเลิกการจอง
if (isset($_GET['delete'])) {
    $delete_HN = $_GET['delete'];

    // ดึงข้อมูลที่จะถูกลบออกมาจากตาราง 'book'
    $selectstmt = $conn->prepare("SELECT * FROM book WHERE HN = ?");
    $selectstmt->bindParam(1, $delete_HN, PDO::PARAM_STR);
    $selectstmt->execute();
    $result = $selectstmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // เพิ่มข้อมูลลงในตาราง 'history'
        $insertstmt = $conn->prepare("INSERT INTO history (h_HN, h_Cdate, h_Adate, h_name, h_book, h_dp, h_room, h_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertstmt->bindParam(1, $result['HN'], PDO::PARAM_STR);
        $insertstmt->bindParam(2, $result['current_datetime'], PDO::PARAM_STR);
        $insertstmt->bindParam(3, $result['appointment_date'], PDO::PARAM_STR);
        $insertstmt->bindParam(4, $result['S_name'], PDO::PARAM_STR);
        $insertstmt->bindParam(5, $result['booked_by'], PDO::PARAM_STR);
        $insertstmt->bindParam(6, $result['Department'], PDO::PARAM_STR);
        $insertstmt->bindParam(7, $result['room'], PDO::PARAM_STR);
        $insertstmt->bindParam(8, $result['Status'], PDO::PARAM_STR); // เพิ่มคอลัมน์ h_status
        $insertstmt->execute();

        // ลบข้อมูลจากตาราง 'book'
        $deletestmt = $conn->prepare("DELETE FROM book WHERE HN = ?");
        $deletestmt->bindValue(1, $delete_HN, PDO::PARAM_STR); // ใช้ bindValue แทน bindParam
        $deletestmt->execute();

        if ($deletestmt && $insertstmt) {
            echo "<script>alert('การจองถูกยกเลิกเเละข้อมูลถูกจัดเก็บในประวัติการจอง');</script>";
            $_SESSION['success'] = "การจองถูกยกเลิกเเละข้อมูลถูกจัดเก็บในประวัติการจอง";
            header("refresh:1; url=officer_approve.php");
        }
    } else {
        echo "<script>alert('ไม่พบข้อมูล');</script>";
    }
}



// เสร็จสิ้นการจอง
if (isset($_GET['finish'])) {
    $finish_HN = $_GET['finish'];

    // ดึงข้อมูลการจองที่ต้องการยกเลิก
    $selectstmt = $conn->prepare("SELECT * FROM book WHERE HN = ?");
    $selectstmt->bindParam(1, $finish_HN, PDO::PARAM_STR);
    $selectstmt->execute();
    $result = $selectstmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // เพิ่มข้อมูลลงในตาราง 'history' พร้อมกับการเพิ่มคอลัมน์ 'h_status' ในตาราง 'history'
        $insertstmt = $conn->prepare("INSERT INTO history (h_HN, h_Cdate, h_Adate, h_name, h_book, h_dp, h_room, h_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertstmt->bindParam(1, $result['HN'], PDO::PARAM_STR);
        $insertstmt->bindParam(2, $result['current_datetime'], PDO::PARAM_STR);
        $insertstmt->bindParam(3, $result['appointment_date'], PDO::PARAM_STR);
        $insertstmt->bindParam(4, $result['S_name'], PDO::PARAM_STR);
        $insertstmt->bindParam(5, $result['booked_by'], PDO::PARAM_STR);
        $insertstmt->bindParam(6, $result['Department'], PDO::PARAM_STR);
        $insertstmt->bindParam(7, $result['room'], PDO::PARAM_STR);
        $status_finish = "เสร็จสิ้นการจอง"; // สถานะ "เสร็จสิ้นการจอง"
        $insertstmt->bindParam(8, $status_finish, PDO::PARAM_STR);
        $insertstmt->execute();

        // ลบข้อมูลการจองจากตาราง 'book'
        $deletestmt = $conn->prepare("DELETE FROM book WHERE HN = ?");
        $deletestmt->bindValue(1, $finish_HN, PDO::PARAM_STR);
        $deletestmt->execute();

        if ($deletestmt && $insertstmt) {
            // ดึงค่าปัจจุบันของ $rt_num จากฐานข้อมูล
            $selectRtNumStmt = $conn->prepare("SELECT rt_num FROM room_type WHERE rt_type = :roomType");
            $roomType = $result['room']; // ชื่อของห้องที่เกี่ยวข้องกับการจอง
            $selectRtNumStmt->bindParam(':roomType', $roomType, PDO::PARAM_STR);
            $selectRtNumStmt->execute();
            $currentRtNum = $selectRtNumStmt->fetchColumn();

            // เพิ่มค่าปัจจุบันของ $rt_num ด้วย 1
            $newRtNum = $currentRtNum + 1;

            // อัปเดตค่า $rt_num ในฐานข้อมูล
            $updateRtNumStmt = $conn->prepare("UPDATE room_type SET rt_num = :newRtNum WHERE rt_type = :roomType");
            $updateRtNumStmt->bindParam(':newRtNum', $newRtNum, PDO::PARAM_INT);
            $updateRtNumStmt->bindParam(':roomType', $roomType, PDO::PARAM_STR);

            if ($updateRtNumStmt->execute()) {
                echo "<script>alert('การจองเสร็จสิ้นและข้อมูลถูกจัดเก็บในประวัติการจอง');</script>";
                $_SESSION['success'] = "การจองเสร็จสิ้นและข้อมูลถูกจัดเก็บในประวัติการจอง";
                header("refresh:1; url=officer_approve.php");
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตค่า rt_num');</script>";
            }
        }
    } else {
        echo "<script>alert('ไม่พบข้อมูล');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลการจอง</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/indexcss.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">

</head>

<body>
    <?php
    if (isset($_SESSION['officer_login'])) {
        $officer_id = $_SESSION['officer_login'];
        $stmt = $conn->query("SELECT * FROM member WHERE m_id = $officer_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    include("navbar.php")
    ?>

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

    <div class="container">
        <div class="row">

            <div class="texthh">
                <h3>จัดการข้อมูลการจอง</h3>
                <hr>
            </div>

            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

            <table class="table table-bordered small-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">HN ผู้ป่วย</th>
                        <th scope="col">วันและเวลาที่ทำการจอง</th>
                        <th scope="col">วันที่แพทย์นัดนอนโรงพยาบาล</th>
                        <th scope="col">ชื่อ-นามสกุล(ผู้ป่วย)</th>
                        <th scope="col">แผนก</th>
                        <th scope="col">ชื่อ-นามสกุล(ผู้จอง)</th>
                        <th scope="col">ห้องพัก</th>
                        <th scope="col">สถานะ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $stmt = $conn->query("SELECT * FROM book");
                    $stmt->execute();
                    $book = $stmt->fetchAll();

                    if (!$book) {
                        echo "<p><td colspan='10' class='text-center'>No data available</td></p>";
                    } else {
                        $i = 1;
                        foreach ($book as $rbook) {
                    ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td><?php echo $rbook['HN']; ?></td>
                                <td><?php echo $rbook['current_datetime']; ?></td>
                                <td><?php echo $rbook['appointment_date']; ?></td>
                                <td><?php echo $rbook['S_name']; ?></td>
                                <td><?php echo $rbook['Department']; ?></td>
                                <td><?php echo $rbook['booked_by']; ?></td>
                                <td><?php echo $rbook['room']; ?></td>
                                <td><?php echo $rbook['Status']; ?></td>
                                <td>
                                    <?php if ($rbook['Status'] == 'รออนุมัติ') { ?>
                                        <a href="?approve=<?php echo $rbook['HN']; ?>" class="btn btn-info">อนุมัติ</a>
                                        <a onclick="return confirm('คุณต้องการยกเลิกการจองใช่หรือไม่?');" href="?delete=<?php echo $rbook['HN']; ?>" class="btn btn-danger">ยกเลิกการจอง</a>
                                    <?php } elseif ($rbook['Status'] == 'อนุมัติ') { ?>
                                        <a href="?approve=<?php echo $rbook['HN']; ?>" class="btn btn-info">อนุมัติ</a>
                                        <a href="?finish=<?php echo $rbook['HN']; ?>" class="btn btn-success">เสร็จสิ้นการจอง</a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                            $i++;
                        }
                    } ?>
                </tbody>

            </table>
        </div>


        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>