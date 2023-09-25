<?php

session_start();
require_once('db.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอก username';
        header("location: login_page.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอก password';
        header("location: login_page.php");
    } else {

        try {

            $check_data = $conn->prepare("SELECT * FROM member WHERE m_username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {

                if ($username == $row['m_username'] && $password == $row['m_password']) {
                        if ($row['m_level'] == 'admin') {
                            $_SESSION['admin_login'] = $row['m_id'];
                            header("location: admin_index.php");
                        } else {
                            $_SESSION['officer_login'] = $row['m_id'];
                            header("location: officer_index.php");
                        }
                } else {
                    $_SESSION['error'] = 'กรอก username หรือ password ผิด';
                    header("location: login_page.php");
                }
            } else {
                $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
                header("location: login_page.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
