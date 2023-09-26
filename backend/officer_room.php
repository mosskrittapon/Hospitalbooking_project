<?php

session_start();

require_once('db.php');

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM room_type WHERE rt_id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
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
    <title>ประเภทห้องพัก</title>

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
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มประเภทห้องพัก</h5>
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
                            <input type="text" required class="form-control" name="rprice">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">รูป:</label>
                            <input type="file" required class="form-control" id="imgInput" name="img">
                            <img loading="lazy" width="100%" id="previewImg" alt="">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
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


    <div class="ct2">
        <div class="row">
            <div class="col-md-6">
                <h3>จัดการประเภทห้องพัก</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">เพิ่มประเภทห้องพัก</button>
            </div>
        </div>
        <hr>
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
                            <td>
                                <a href="room_edit.php?rt_id=<?php echo $roomt['rt_id']; ?>" class="btn btn-warning">แก้ไขข้อมูล</a>
                                <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $roomt['rt_id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
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
</body>

</html>