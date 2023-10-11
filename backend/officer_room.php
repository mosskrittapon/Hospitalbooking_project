<?php

session_start();

require_once('db.php');

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM room_type WHERE rt_id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('ข้อมูลถูกลบเรียบร้อยแล้ว');</script>";
        $_SESSION['success'] = "ข้อมูลถูกลบเรียบร้อยแล้ว";
        header("refresh:1; url=officer_room.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการห้องพักผู้ป่วย</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="css/indexcss4.css">


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
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มห้องพักผู้ป่วย</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="room_insert.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="type" class="col-form-label">ประเภทของห้องพัก:</label>
                            <input type="text" required class="form-control" name="rtype">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="col-form-label">ราคาต่อคืน(บาท):</label>
                            <input type="number" required class="form-control" name="rprice">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">รูป:</label>
                            <input type="file" required class="form-control" id="imgInput" name="img">
                            <img loading="lazy" width="100%" id="previewImg" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="num" class="col-form-label">จำนวนห้องพัก:</label>
                            <input type="number" required class="form-control" name="rnum">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

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


    <div class="ct2">
        <div class="row">
            
            <div class="col-md-6">
                <h3>จัดการห้องพักผู้ป่วย</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">เพิ่มห้องพักผู้ป่วย</button>
            </div>

            <div class="hrr">
                <hr>
            </div>

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
                    <th scope="col">ประเภทของห้องพัก</th>
                    <th scope="col">ราคาต่อคืน(บาท)</th>
                    <th scope="col">รูป</th>
                    <th scope="col">จำนวนห้องพัก</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM room_type");
                $stmt->execute();
                $roomType = $stmt->fetchAll();

                if (!$roomType) {
                    echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                } else {
                    $i = 1;
                    foreach ($roomType as $roomt) {

                ?>
                        <tr>
                            <td> <?php echo $i; ?> </td>
                            <td><?php echo $roomt['rt_type']; ?></td>
                            <td><?php echo $roomt['rt_price']; ?></td>
                            <td width="225px"><img class="rounded" width="100%" src="uploads/<?php echo $roomt['rt_img']; ?>" alt=""></td>
                            <td><?php echo $roomt['rt_num']; ?></td>
                            <td>
                                <a href="room_edit.php?rt_id=<?php echo $roomt['rt_id']; ?>" class="btn btn-warning">แก้ไขข้อมูล</a>
                                <a onclick="return confirm('คุณต้องการจะลบข้อมูลใช่หรือไม่?');" href="?delete=<?php echo $roomt['rt_id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
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
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file)
            }
        }
    </script>
    <script>
        // ฟังก์ชันเมื่อครบ 1 วิ ให้ปุ่มเเจ้ง update หายไป
        function hideMessages() {
            var successAlert = document.querySelector(".alert-success");
            var errorAlert = document.querySelector(".alert-danger");

            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = "none";
                }, 1000);
            }

            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.display = "none";
                }, 1000);
            }
        }
        window.onload = function() {
            hideMessages();
        };
    </script>
</body>

</html>