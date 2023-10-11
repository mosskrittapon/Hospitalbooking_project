<?php

session_start();

require_once('db.php');

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM room_num WHERE rn_id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=officer_nroom.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถานะห้องพัก</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/indexcss.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">


</head>

<body>
    <?php
    if (isset($_SESSION['officer_login'])) {
        $officer_id = $_SESSION['officer_login'];
        $stmt = $conn->query("SELECT * FROM member WHERE m_id = $officer_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    include("navbar.php")
    ?>
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มห้องพัก</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="nroom_insert.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">หมายเลขห้องพัก:</label>
                            <input type="text" required class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="rtid" class="col-form-label">ประเภทห้องพัก:</label>
                            <div class="mb-3">
                                <select name="rtid" class="form-select">
                                    <option value="" selected="selected"> โปรดเลือก...</option>
                                    <?php
                                    $type = $conn->query("SELECT * FROM room_type");
                                    while ($type_data = $type->fetch(PDO::FETCH_ASSOC)) {
                                        $type_name[$type_data['rt_id']] = $type_data['rt_type'];
                                    ?>
                                        <option value="<?php echo $type_data['rt_id'] ?>"><?php echo $type_data['rt_type'] ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rnstatus" class="col-form-label">สถานะห้องพัก:</label>
                            <div class="mb-3">
                                <select name="rnstatus" class="form-select">
                                    <option value="" selected="selected"> โปรดเลือก...</option>
                                    <option value="ห้องว่าง"> ห้องว่าง </option>
                                    <option value="ห้องไม่ว่าง"> ห้องไม่ว่าง </option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <nav class="sidebar">
        <ul class="nav flex-column">
            <hr>
            <div class="ad-name">
                <h1> <?php echo  $row['m_firstname'] . ' ' . $row['m_lastname'] ?> </h1>
            </div>
            <hr>
            <li class="nav-item">
                <a class="nav-link" href="officer_index.php"> หน้าหลัก </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="officer_department.php"> แผนกผู้ป่วย </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="officer_room.php"> ประเภทห้องพัก </a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" href="officer_nroom.php"> สถานะห้องพัก </a>
            </li>-->
            <li class="nav-item">
                <a class="nav-link" href="officer_approve.php"> ข้อมูลการจอง </a>
            </li>
            <div class="boxout">
                <div class="endout">
                    <li class="nav-item">
                        <a class="nav-link" href="login_page.php"> ออกจากระบบ </a>
                    </li>
                </div>
            </div>
        </ul>
    </nav>


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>จัดการสถานะห้องพัก</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">เพิ่มห้องพัก</button>
            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">หมายเลขห้องพัก</th>
                    <th scope="col">ประเภทของห้องพัก</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT room_num.*, room_type.rt_type, room_type.rt_type
                    FROM room_num 
                    LEFT JOIN room_type ON room_num.rt_id = room_type.rt_id");

                $stmt->execute();
                $room_num = $stmt->fetchAll();

                if (!$room_num) {
                    echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                } else {
                    $i = 1;
                    foreach ($room_num as $room_n) {
                ?>
                        <tr>
                            <td> <?php echo $i; ?> </td>
                            <td><?php echo $room_n['rn_name']; ?></td>
                            <td><?php echo $room_n['rt_type']; ?></td>
                            <td><?php echo $room_n['rn_status']; ?></td>
                            <td>
                                <a href="nroom_edit.php?rn_id=<?php echo $room_n['rn_id']; ?>" class="btn btn-warning">เเก้ไขข้อมูล</a>
                                <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $room_n['rn_id']; ?>" class="btn btn-danger">ลบข้อมูล</a>
                            </td>
                        </tr>
                <?php
                        $i++;
                    }
                } ?>
            </tbody>

        </table>
    </div>


    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>