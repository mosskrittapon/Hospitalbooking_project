<?php
session_start();

require_once('db.php');

//อนุมัติการจอง
if (isset($_GET['approve'])) {
    $approve_HN = $_GET['approve'];
    $stmt = $conn->query("SELECT status FROM book WHERE HN =  $approve_HN");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $newStatus = $row['status'] == 'อนุมัติ' ? 'รออนุมัติ' : 'อนุมัติ';

    $approvetmt = $conn->prepare("UPDATE book SET status = :newStatus WHERE HN = :approveHN");
    $approvetmt->bindParam(':newStatus', $newStatus);
    $approvetmt->bindParam(':approveHN',  $approve_HN);
    $approvetmt->execute();

    if ($approvetmt) {
        $_SESSION['success'] = "Status has been changed successfully";
        header("refresh:2; url=officer_approve.php");
    }
}

//ลบข้อมูล
if (isset($_GET['delete'])) {
    $delete_HN = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM book WHERE HN = $delete_HN");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=officer_nroom.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อนุมัติการจอง</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/indexcss.css">
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
                <a class="nav-link" href="officer_index.php"> หน้าหลัก</a>
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

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>อนุมัติการจอง</h3>
                <hr style="width:204%; margin-left:0">
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
                        <th scope="col">ชื่อ-นามสกุล(ผู้ป่วย)</th>
                        <th scope="col">แผนก</th>
                        <th scope="col">ชื่อ-นามสกุล(ผู้จอง)</th>
                        <th scope="col">ประเภทห้องพัก</th>
                        <th scope="col">สถานะการจอง</th>
                        <th scope="col">จัดการ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $stmt = $conn->query("SELECT * FROM book");
                    $stmt->execute();
                    $book = $stmt->fetchAll();

                    if (!$book) {
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    } else {
                        $i = 1;
                        foreach ($book as $rbook) {
                    ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td><?php echo $rbook['HN']; ?></td>
                                <td><?php echo $rbook['S_name']; ?></td>
                                <td><?php echo $rbook['Department']; ?></td>
                                <td><?php echo $rbook['booked_by']; ?></td>
                                <td><?php echo $rbook['room']; ?></td>
                                <td><?php echo $rbook['Status']; ?></td>
                                <td>
                                    <a href="?approve=<?php echo $rbook['HN']; ?>" class="btn btn-info">เปลี่ยนสถานะการจอง</a>
                                    <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $rbook['HN']; ?>" class="btn btn-danger">ลบข้อมูล</a>
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