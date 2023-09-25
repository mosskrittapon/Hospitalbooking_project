<?php

session_start();
require_once('db.php');

if (isset($_POST['submit'])) {
    $m_firstname = $_POST['firstname'];
    $m_lastname = $_POST['lastname'];
    $m_username = $_POST['username'];
    $m_password = $_POST['password'];
    $m_level = $_POST['level'];

    $sql = $conn->prepare("INSERT INTO member(m_firstname, m_lastname, m_username, m_password, m_level) VALUES(:firstname, 
    :lastname, :username, :password, :level)");
    $sql->bindParam(":firstname", $m_firstname);
    $sql->bindParam(":lastname", $m_lastname);
    $sql->bindParam(":username", $m_username);
    $sql->bindParam(":password", $m_password);
    $sql->bindParam(":level", $m_level);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted successfully";
        header("location: admin_member.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted successfully";
        header("location: admin_member.php");
    }
}
