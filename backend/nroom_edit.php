<?php

session_start();
require_once('db.php');

if (isset($_POST['update'])) {
    $rn_id = $_POST['rnid'];
    $rt_id = $_POST['rtid'];
    $rn_name = $_POST['name'];
    $rn_status = $_POST['rnstatus'];

    $sql = $conn->prepare("UPDATE room_num SET rt_id = :rtid, rn_name = :name, rn_status = :rnstatus WHERE rn_id = :rnid");
    $sql->bindParam(":rnid", $rn_id);
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Room Data</h1>
        <hr>
        <form action="nroom_edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['rn_id'])) {
                $rn_id = $_GET['rn_id'];
                $stmt = $conn->query("SELECT * FROM room_num WHERE rn_id = $rn_id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>
            <input type="hidden" readonly value="<?php echo $data['rn_id']; ?>" required class="form-control" name="rnid">
            <div class="mb-3">
                <label for="name" class="col-form-label">หมายเลขห้องพัก:</label>
                <input type="text" value="<?php echo $data['rn_name']; ?>" required class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label for="rtid" class="col-form-label">ประเภทห้องพัก:</label>
                <select name="rtid" class="form-select">
                    <?php
                    $type = $conn->query("SELECT * FROM room_type");
                    while ($type_data = $type->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($type_data['rt_id'] === $data['rt_id']) ? 'selected="selected"' : '';
                    ?>
                        <option value="<?php echo $type_data['rt_id']; ?>" <?php echo $selected; ?>><?php echo $type_data['rt_type']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="rnstatus" class="col-form-label">สถานะห้องพัก:</label>
                <select name="rnstatus" class="form-select">
                    <option value="ห้องว่าง" <?php if ($data['rn_status'] === 'ห้องว่าง') echo 'selected="selected"'; ?>>ห้องว่าง</option>
                    <option value="ห้องไม่ว่าง" <?php if ($data['rn_status'] === 'ห้องไม่ว่าง') echo 'selected="selected"'; ?>>ห้องไม่ว่าง</option>
                </select>
            </div>

            <hr>
            <a href="officer_nroom.php" class="btn btn-secondary">Go Back</a>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>