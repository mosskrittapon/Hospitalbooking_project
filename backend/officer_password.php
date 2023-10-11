<?php
session_start();
require_once('db.php');

if (isset($_SESSION['officer_login'])) {
    $officer_id = $_SESSION['officer_login'];
    $stmt = $conn->prepare("SELECT * FROM member WHERE m_id = :officer_id");
    $stmt->bindParam(":officer_id", $officer_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user's role is 'officer'
    if ($row['m_level'] === 'officer') {
        $m_id = $row['m_id'];
        $m_password = $row['m_password'];

        if (isset($_POST['update_password'])) {
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($old_password === $row['m_password']) {

                if ($new_password === $confirm_password) {
                    $sql = $conn->prepare("UPDATE member SET m_password = :password WHERE m_id = :id");
                    $sql->bindParam(":id", $m_id);
                    $sql->bindParam(":password", $new_password);
                    $sql->execute();

                    if ($sql) {
                        $_SESSION['success'] = "รหัสผ่านถูกเปลี่ยนแล้ว";

                    } else {
                        $_SESSION['error'] = "การอัปเดตรหัสผ่านไม่สำเร็จ";
                    }
                } else {
                    $_SESSION['error'] = "รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน";
                }
            } else {
                $_SESSION['error'] = "รหัสผ่านเดิมไม่ถูกต้อง";
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
    <title>เปลี่ยนรหัสผ่าน</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/memberEditCSS.css">

    <style>
        .container {
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>เปลี่ยนรหัสผ่าน</h2>
        <hr>
        <form action="officer_password.php" method="post" enctype="multipart/form-data">
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
            <div class="mb-3 pass-table">
                <label for="old_password" class="col-form-label">รหัสผ่านเดิม:</label>
                <div class="pass-cus">
                    <input type="password" required class="form-control" name="old_password" id="old_password">
                    <div class="input-group-append">
                        <span class="input-group-text" onclick='password_show_hide("old_password", "show_eye_old", "hide_eye_old");'>
                            <i class="bi bi-eye-fill" id="show_eye_old"></i>
                            <i class="bi bi-eye-slash-fill d-none" id="hide_eye_old"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3 pass-table">
                <label for="new_password" class="col-form-label">รหัสผ่านใหม่:</label>
                <div class="pass-cus">
                    <input type="password" required class="form-control" name="new_password" id="new_password">
                    <div class="input-group-append">
                        <span class="input-group-text" onclick='password_show_hide("new_password", "show_eye_new", "hide_eye_new");'>
                            <i class="bi bi-eye-fill" id="show_eye_new"></i>
                            <i class="bi bi-eye-slash-fill d-none" id="hide_eye_new"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3 pass-table">
                <label for="confirm_password" class="col-form-label">ยืนยันรหัสผ่านใหม่:</label>
                <div class="pass-cus">
                    <input type="password" required class="form-control" name="confirm_password" id="confirm_password">
                    <div class="input-group-append">
                        <span class="input-group-text" onclick='password_show_hide("confirm_password", "show_eye_confirm", "hide_eye_confirm");'>
                            <i class="bi bi-eye-fill" id="show_eye_confirm"></i>
                            <i class="bi bi-eye-slash-fill d-none" id="hide_eye_confirm"></i>
                        </span>
                    </div>
                </div>
            </div>

            <hr>
            <a href="officer_profile.php" class="btn btn-secondary">ย้อนกลับ</a>
            <button type="submit" name="update_password" class="btn btn-primary">อัปเดตรหัสผ่าน</button>
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