<?php

require_once('dbcon.php');

require_once('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital</title>
    <link rel="stylesheet" href="css/style1-1.css">
    <link rel="stylesheet" href="css/style2-1.css">



    <style>
        body {
            margin: 0;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">

</head>


<body>
    <div class="bar">
        <div class="topic">
            <div class="logo"></div>
            <div class="navtext">
                <p>โรงพยาบาลปอปลาตากลม</p>
                <div class="bargreen"></div>
                <div class="navtext2">
                    <p>จังหวัดมอ.หาดใหญ่</p>
                </div>
            </div>

            <div class="boxbt">
                <div class="bt">
                    <a href="main.php">หน้าหลัก</a>
                    <a href="register.php">ลงทะเบียน</a>
                    <a href="booking.php">จองห้องพัก</a>
                    <a href="cancel.php">ยกเลิกห้องพัก</a>
                    <a href="check.php">ตรวจสอบการจอง</a>
                    <a href="contact.php">ติดต่อสอบถาม</a>
                </div>

            </div>

        </div>




        <div class="header">

            <div class="bgwhite">

                <div class="centerallbook">

                    <div class="centerboooking">


                        <div class="textbgwhite">

                            <p>กรุณาเลือกห้องพักที่เปิดให้บริการ</p>

                        </div>

                        <?php

                        $firstRoom = true; // ใช้ตัวแปรเพื่อตรวจสอบห้องแรก
                        while ($row = mysqli_fetch_assoc($result)) {
                            $rt_id = $row['rt_id'];
                            $rt_type = $row['rt_type'];
                            $rt_price = $row['rt_price'];
                            $rt_img = $row['rt_img'];
                            $rt_num = $row['rt_num'];
                            $empty_rooms = $row['rt_num'];

                            $roomClass = $firstRoom ? 'show' : ''; // ให้กำหนดคลาส 'show' เฉพาะห้องแรก
                            $firstRoom = false; // เปลี่ยนค่าเป็น false หลังจากกำหนดคลาสแล้ว
                        ?>

                            <div class="room-content rm <?= $roomClass; ?>">
                                <div class="ptroom">
                                    <div class="roomone">
                                        <img src="backend/uploads/<?php echo $rt_img; ?>">
                                        <p><?= $rt_type; ?></p>
                                    </div>
                                </div>

                                <div class="dataroom">
                                    <div class="dataone">
                                        <div class="boxdataall">

                                            <div class="boxdata">
                                                    <p>จำนวนห้องว่าง : <?= $rt_num; ?> </p>
                                            </div>




                                            <div class="boxdatasmall">
                                                <p>ราคา <?= $rt_price; ?> / คืน</p>
                                            </div>

                                            <?php if ($empty_rooms > 0) { ?>
                                                <a href="summit_1.php?room=<?= $rt_type; ?>" class="boxdatablacksmall">
                                                    <p>ทำการจองห้องพัก</p>
                                                </a>
                                            <?php } else { ?>
                                                <div class="boxdatablacksmall" style="display: none;">
                                                    <p>ทำการจองห้องพัก</p>
                                                </div>
                                            <?php } ?>


                                            <?php if ($empty_rooms <= 0) { ?>
                                                <div class="boxdatablacksmallsos">
                                                    <p>ห้องพักเต็ม</p>
                                                </div>
                                            <?php } ?>



                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>





                        <div class="room-selector">
                            <button onclick="showRoom('btl')">❮</button>
                            <button onclick="showRoom('btr')">❯</button>
                        </div>








                    </div>

                </div>
            </div>




        </div>








        <script src="Js/script.js"></script>






</body>

</html>