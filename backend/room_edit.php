<?php

session_start();
require_once('db.php');

if (isset($_POST['update'])) {
    $rt_id = $_POST['rid'];
    $r_type = $_POST['rtype'];
    $r_price = $_POST['rprice'];
    $r_img = $_FILES['img'];

    $img2 = $_POST['img2'];
    $upload = $_FILES['img']['name'];

    if ($upload != '') {
        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $r_img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;  
        $filePath = 'uploads/' . $fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($r_img['size'] > 0 && $r_img['error'] == 0) {
                move_uploaded_file($r_img['tmp_name'], $filePath);
            }
        }
    } else {
        $fileNew = $img2;
    }

    $sql = $conn->prepare("UPDATE room_type SET rt_type = :rtype, rt_price = :rprice, rt_img = :img WHERE rt_id = :rid");
    $sql->bindParam(":rid", $rt_id);
    $sql->bindParam(":rtype", $r_type);
    $sql->bindParam(":rprice", $r_price);
    $sql->bindParam(":img", $fileNew);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been updated successfully";
        header("location: officer_room.php");
    } else {
        $_SESSION['error'] = "Data has not been updated successfully";
        header("location: officer_room.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room Category Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Room Category Data</h1>
        <hr>
        <form action="room_edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['rt_id'])) {
                $rt_id = $_GET['rt_id'];
                $stmt = $conn->query("SELECT * FROM room_type WHERE rt_id = $rt_id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>
            <div class="mb-3">
                <input type="hidden" readonly value="<?php echo $data['rt_id']; ?>" required class="form-control" name="rid">
                <label for="type" class="col-form-label">ประเภทของห้องพัก:</label>
                <input type="text" value="<?php echo $data['rt_type']; ?>" required class="form-control" name="rtype">
                <input type="hidden" value="<?php echo $data['rt_img']; ?>" required class="form-control" name="img2">
            </div>
            <div class="mb-3">
                <label for="price" class="col-form-label">ราคาต่อคืน(บาท):</label>
                <input type="text" value="<?php echo $data['rt_price']; ?>" required class="form-control" name="rprice">
            </div>
            <div class="mb-3">
                <label for="img" class="col-form-label">รูป:</label>
                <input type="file" class="form-control" id="imgInput" name="img">
                <img width="65%" src="uploads/<?php echo $data['rt_img']; ?>" id="previewImg" alt="">
            </div>
            <hr>
            <a href="officer_room.php" class="btn btn-secondary">Go Back</a>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file)
            }
        }
    </script>
</body>

</html>