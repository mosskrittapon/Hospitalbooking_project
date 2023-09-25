<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/loginCSS.css">
    <title>login</title>
</head>

<body>
    <div class="login-form">
        <h2>เข้าสู่ระบบ</h2>
        <form action="login_db.php" method="post">
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger custom-alert" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success custom-alert" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>

            <div class=" input-field">
                <i class="fa fa-user"></i>
                <input type="username" placeholder="Username" name="username">
            </div>

            <div class="input-field">
                <i class="fa fa-lock"></i>
                <input type="password" placeholder="Password" name="password">
            </div>

            <button type="submit" name="submit">Sign in </button>

            <div class="extra">
                <a href="/thesisfull/main.php"> กลับสู่หน้าหลักของระบบ</a>
            </div>

        </form>
    </div>

</body>

</html>