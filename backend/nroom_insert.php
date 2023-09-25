<?php

session_start();
require_once('db.php');

if (isset($_POST['submit'])) {
    $rt_id= $_POST['rtid'];
    $rn_name = $_POST['name'];
    $rn_status = $_POST['rnstatus'];


    $sql = $conn->prepare("INSERT INTO room_num(rt_id, rn_name, rn_status) VALUES(:rtid, :name, :rnstatus)");
    $sql->bindParam(":rtid", $rt_id);
    $sql->bindParam(":name", $rn_name);
    $sql->bindParam(":rnstatus", $rn_status);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted successfully";
        header("location: officer_nroom.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted successfully";
        header("location: officer_nroom.php");
    }
}