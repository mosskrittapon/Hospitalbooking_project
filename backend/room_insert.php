<?php 

session_start();
require_once('db.php');

if (isset($_POST['submit'])) {
    $r_type = $_POST['rtype'];
    $r_price = $_POST['rprice'];
    $r_img = $_FILES['img'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $r_img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt; 
        $filePath = 'uploads/'.$fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($r_img['size'] > 0 && $r_img['error'] == 0) {
                if (move_uploaded_file($r_img['tmp_name'], $filePath)) {
                    $sql = $conn->prepare("INSERT INTO room_type(rt_type, rt_price, rt_img) VALUES(:rtype, :rprice, :rimg)");
                    $sql->bindParam(":rtype", $r_type);
                    $sql->bindParam(":rprice", $r_price);
                    $sql->bindParam(":rimg", $fileNew);
                    $sql->execute();

                    if ($sql) {
                        $_SESSION['success'] = "Data has been inserted successfully";
                        header("refresh:1; url=officer_room.php");
                    } else {
                        $_SESSION['error'] = "Data has not been inserted successfully";
                        header("refresh:1; url=officer_room.php");
                    }
                }
            }
        }
}
