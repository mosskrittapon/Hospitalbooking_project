<?php

session_start();
require_once('db.php');

if (isset($_POST['submit'])) {
    $d_id = $_POST['did'];
    $d_name = $_POST['dname'];

    $sql = $conn->prepare("INSERT INTO department(d_id, d_name) VALUES(:did, :dname)");
    $sql->bindParam(":did", $d_id);
    $sql->bindParam(":dname", $d_name);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "ข้อมูลถูกเพิ่มเรียบร้อยเเล้ว";
        header("location: officer_department.php");
    } else {
        $_SESSION['error'] = "การเพิ่มข้อมูลไม่สำเร็จ";
        header("location: officer_department.php");
    }
}
