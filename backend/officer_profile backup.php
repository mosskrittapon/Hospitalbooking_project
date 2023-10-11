<?php
session_start();
require_once('db.php');

// Check if the user is logged in and has the 'officer' role
if (isset($_SESSION['officer_login'])) {
    $officer_id = $_SESSION['officer_login'];
    $stmt = $conn->prepare("SELECT * FROM member WHERE m_id = :officer_id");
    $stmt->bindParam(":officer_id", $officer_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user's role is 'officer'
    if ($row['m_level'] === 'officer') {
        $m_id = $row['m_id'];
        $m_firstname = $row['m_firstname'];
        $m_lastname = $row['m_lastname'];
        $m_username = $row['m_username'];
        $m_password = $row['m_password'];

        if (isset($_POST['update'])) {
            $m_id = $_POST['id'];
            $m_firstname = $_POST['firstname'];
            $m_lastname = $_POST['lastname'];
            $m_username = $_POST['username'];
            $m_password = $_POST['password'];

            // Update the user's data
            $sql = $conn->prepare("UPDATE member SET m_firstname = :firstname, m_lastname = :lastname, m_username = :username, 
            m_password = :password WHERE m_id = :id");
            $sql->bindParam(":id", $m_id);
            $sql->bindParam(":firstname", $m_firstname);
            $sql->bindParam(":lastname", $m_lastname);
            $sql->bindParam(":username", $m_username);
            $sql->bindParam(":password", $m_password);
            $sql->execute();

            if ($sql) {
                $_SESSION['success'] = "ข้อมูลถูกอัปเดตเรียบร้อยเเล้ว";
                header("location: officer_profile.php");
                exit();
            } else {
                $_SESSION['error'] = "การอัปเดตข้อมูลไม่สำเร็จ";
                header("location: officer_profile.php");
                exit();
            }
        }
    } else {
        echo "คุณไม่มีสิทธิ์เข้าถึงหน้านี้";
    }
} else {
    echo "โปรดเข้าสู่ระบบในฐานะเจ้าหน้าที่";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/memberEditCSS.css">

    <style>
        .container {
            max-width: 450px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>เเก้ไขโปรไฟล์</h2>
        <hr>
        <form action="officer_profile.php" method="post" enctype="multipart/form-data">
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

            <input type="hidden" readonly value="<?php echo $m_id; ?>" required class="form-control" name="id">
            <div class="mb-3">
                <label for="firstname" class="col-form-label">ชื่อจริง:</label>
                <input type="text" value="<?php echo $m_firstname; ?>" required class="form-control" name="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="col-form-label">นามสกุล:</label>
                <input type="text" value="<?php echo $m_lastname; ?>" required class="form-control" name="lastname">
            </div>
            <div class="mb-3">
                <label for="username" class="col-form-label">Username:</label>
                <input type="text" value="<?php echo $m_username; ?>" required class="form-control" name="username">
            </div>
            <div class="mb-3 pass-table">
                <label for="password" class="col-form-label">Password:</label>
                <div class="pass-cus">
                    <input type="password" value="<?php echo $m_password; ?>" required class="form-control" id="password" name="password">
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide();">
                            <i class="bi bi-eye-fill" id="show_eye"></i>
                            <i class="bi bi-eye-slash-fill d-none" id="hide_eye"></i>
                        </span>
                    </div>
                </div>
            </div>

            <hr>
            <a href="officer_index.php" class="btn btn-secondary">ย้อนกลับ</a>
            <button type="submit" name="update" class="btn btn-primary">อัปเดต</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="JS/hidebutton.js"></script>
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