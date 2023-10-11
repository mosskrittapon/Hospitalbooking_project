<?php

require_once('dbcon.php');


$query = "SELECT rt_id, rt_type, rt_price, rt_img, rt_num,
            IF(rt_num = 0, 'empty', 'not_empty') AS empty_rooms
            FROM room_type";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("การสอบถามผิดพลาด: " . mysqli_error($conn));
}