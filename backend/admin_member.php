<?php

session_start();
require_once('db.php');

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM member WHERE m_id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('ข้อมูลถูกลบเรียบร้อยแล้ว');</script>";
        $_SESSION['success'] = "ข้อมูลถูกลบเรียบร้อยแล้ว";
        header("refresh:1; url=admin_member.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการเจ้าหน้าที่</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/indexcss.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">

</head>

<body>
    <?php
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * FROM member WHERE m_id = $admin_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    include("navbar.php")
    ?>
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มเจ้าหน้าที่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="member_insert.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ชื่อจริง:</label>
                            <input type="text" required class="form-control" name="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="col-form-label">นามสกุล:</label>
                            <input type="text" required class="form-control" name="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" required class="form-control" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <div class="pass-cus">
                                <input type="password" id="password" required class="form-control" name="password">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="password_show_hide();">
                                        <i class="bi bi-eye-fill" id="show_eye"></i>
                                        <i class="bi bi-eye-slash-fill d-none" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="level" class="col-form-label">ตำเเหน่ง:</label>
                            <div class="mb-3">
                                <select name="level" class="form-select">
                                    <option value="" disabled selected> โปรดเลือก...</option>
                                    <option value="admin"> admin </option>
                                    <option value="officer"> officer </option>
                                </select>
                            </div>
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


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>จัดการเจ้าหน้าที่</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">เพิ่มเจ้าหน้าที่</button>
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

        <table class="table table-bordered" id = "Table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อจริง</th>
                    <th scope="col">นามสกุล</th>
                    <th scope="col">username</th>
                    <th scope="col">password</th>
                    <th scope="col">ตำเเหน่ง</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM member");
                $stmt->execute();
                $member = $stmt->fetchAll();

                if (!$member) {
                    echo "<p><td colspan='7' class='text-center'>No data available</td></p>";
                } else {
                    $i = 1;
                    foreach ($member as $mem) {
                ?>
                        <tr>
                            <td> <?php echo $i; ?> </td>
                            <td><?php echo $mem['m_firstname']; ?></td>
                            <td><?php echo $mem['m_lastname']; ?></td>
                            <td><?php echo $mem['m_username']; ?></td>
                            <td><?php echo $mem['m_password']; ?></td>
                            <td><?php echo $mem['m_level']; ?></td>
                            <td>
                                <a href="member_edit.php?m_id=<?php echo $mem['m_id']; ?>" class="btn btn-warning">แก้ไขข้อมูล</a>
                                <a onclick="return confirm('คุณต้องการจะลบข้อมูลใช่หรือไม่');" href="?delete=<?php echo $mem['m_id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="JS/hidebutton2.js"></script>

</body>

</html>