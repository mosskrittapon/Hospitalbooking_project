<?php

session_start();
require_once('db.php');

if (isset($_POST['update'])) {
    $d_id = $_POST['did'];
    $d_name = $_POST['dname'];


    $sql = $conn->prepare("UPDATE department SET d_id = :did, d_name = :dname WHERE d_id = :did");
    $sql->bindParam(":did", $d_id);
    $sql->bindParam(":dname", $d_name);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been inserted successfully";
        header("location: officer_department.php");
    } else {
        $_SESSION['error'] = "Data has not been inserted successfully";
        header("location: officer_department.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Department Data</h1>
        <hr>
        <form action="department_edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['d_id'])) {
                $d_id = $_GET['d_id'];
                $stmt = $conn->query("SELECT * FROM department WHERE d_id = $d_id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>
            <input type="hidden" readonly value="<?php echo $data['d_id']; ?>" required class="form-control" name="did">
            <div class="mb-3">
                <label for="name" class="col-form-label">ชื่อแผนกผู้ป่วย:</label>
                <input type="text" value="<?php echo $data['d_name']; ?>" required class="form-control" name="dname">
            </div>
            <hr>
            <a href="officer_department.php" class="btn btn-secondary">Go Back</a>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>