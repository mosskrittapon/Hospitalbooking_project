<?php 

session_start();
require_once('db.php');

if (isset($_POST['submit'])) {
    $r_type = $_POST['rtype'];
    $r_price = $_POST['rprice'];
    $r_img = $_FILES['img'];
    $r_num = $_POST['rnum'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $r_img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt; 
        $filePath = 'uploads/'.$fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($r_img['size'] > 0 && $r_img['error'] == 0) {
                if (move_uploaded_file($r_img['tmp_name'], $filePath)) {
                    $sql = $conn->prepare("INSERT INTO room_type(rt_type, rt_price, rt_img, rt_num) VALUES(:rtype, :rprice, :rimg, :rnum)");
                    $sql->bindParam(":rtype", $r_type);
                    $sql->bindParam(":rprice", $r_price);
                    $sql->bindParam(":rimg", $fileNew);
                    $sql->bindParam(":rnum", $r_num);
                    $sql->execute();

                    if ($sql) {
                        $_SESSION['success'] = "ข้อมูลถูกเพิ่มเรียบร้อยเเล้ว";
                        header("refresh:1; url=officer_room.php");
                    } else {
                        $_SESSION['error'] = "การเพิ่มข้อมูลไม่สำเร็จ";
                        header("refresh:1; url=officer_room.php");
                    }
                }
            }
        }
}
