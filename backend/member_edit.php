<?php

session_start();
require_once('db.php');

if (isset($_POST['update'])) {
    $m_id = $_POST['id'];
    $m_firstname = $_POST['firstname'];
    $m_lastname = $_POST['lastname'];
    $m_username = $_POST['username'];
    $m_password = $_POST['password'];
    $m_level = $_POST['level'];

    $sql = $conn->prepare("UPDATE member SET m_firstname = :firstname, m_lastname = :lastname, m_username = :username, 
    m_password = :password, m_level = :level WHERE m_id = :id");
    $sql->bindParam(":id", $m_id);
    $sql->bindParam(":firstname", $m_firstname);
    $sql->bindParam(":lastname", $m_lastname);
    $sql->bindParam(":username", $m_username);
    $sql->bindParam(":password", $m_password);
    $sql->bindParam(":level", $m_level);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "ข้อมูลถูกอัปเดตเรียบร้อยเเล้ว";
        header("location: admin_member.php");
    } else {
        $_SESSION['error'] = "การอัปเดตข้อมูลไม่สำเร็จ";
        header("location: admin_member.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เเก้ไขข้อมูลเจ้าหน้าที่</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/memberEditCSS.css">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>เเก้ไขข้อมูลเจ้าหน้าที่</h1>
        <hr>
        <form action="member_edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['m_id'])) {
                $m_id = $_GET['m_id'];
                $stmt = $conn->query("SELECT * FROM member WHERE m_id = $m_id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>

            <input type="hidden" readonly value="<?php echo $data['m_id']; ?>" required class="form-control" name="id">
            <div class="mb-3">
                <label for="firstname" class="col-form-label">ชื่อจริง:</label>
                <input type="text" value="<?php echo $data['m_firstname']; ?>" required class="form-control" name="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="col-form-label">นามสกุล:</label>
                <input type="text" value="<?php echo $data['m_lastname']; ?>" required class="form-control" name="lastname">
            </div>
            <div class="mb-3">
                <label for="username" class="col-form-label">Username:</label>
                <input type="text" value="<?php echo $data['m_username']; ?>" required class="form-control" name="username">
            </div>
            <div class="mb-3 pass-table">
                <label for="password" class="col-form-label">Password:</label>
                <div class="pass-cus">
                    <input type="password" value="<?php echo $data['m_password']; ?>" required class="form-control" id="password" name="password">
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide();">
                            <i class="bi bi-eye-fill" id="show_eye"></i>
                            <i class="bi bi-eye-slash-fill d-none" id="hide_eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="level" class="col-form-label">ตำแหน่ง:</label>
                <select name="level" class="form-select">
                    <option value="admin" <?php if ($data['m_level'] === 'admin') echo 'selected="selected"'; ?>>admin</option>
                    <option value="officer" <?php if ($data['m_level'] === 'officer') echo 'selected="selected"'; ?>>officer</option>
                </select>
            </div>

            <hr>
            <a href="admin_member.php" class="btn btn-secondary">ย้อนกลับ</a>
            <button type="submit" name="update" class="btn btn-primary">อัปเดต</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="JS/hidebutton2.js"></script>

</body>

</html>