<?php

require_once('dbcon.php');


$query = "SELECT room_type.rt_id, room_type.rt_type, room_type.rt_price, room_type.rt_img,
COUNT(CASE WHEN room_num.rn_status = 'ห้องว่าง' THEN 1 ELSE NULL END) AS empty_rooms
FROM room_type
LEFT JOIN room_num ON room_type.rt_id = room_num.rt_id
GROUP BY room_type.rt_id, room_type.rt_type, room_type.rt_price, room_type.rt_img";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("การสอบถามผิดพลาด: " . mysqli_error($conn));
}