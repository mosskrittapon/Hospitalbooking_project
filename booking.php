<?php
require_once 'db_connection.php';
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





                        <div class="room-content rmone show">


                            <div class="ptroom">
                                <div class="roomone">
                                    <img src="./css/UI/room/1.jpg">
                                    <p>ห้องพักแบบประหยัด</p>
                                </div>
                            </div>


                            <div class="dataroom">
                                <div class="dataone">

                                    <div class="boxdataall">

                                        <div class="boxdata">
                                            <p>จำนวนห้องว่าง : <?php echo $difference; ?> </p>
                                        </div>

                                        <div class="boxdatasmall">
                                            <p>ราคา 300 / คืน</p>
                                        </div>


                                        <?php if ($difference > 0) { ?>
                                            <a href="summit_1.php?room=ห้องพักแบบประหยัด" class="boxdatablacksmall">
                                                <p>ทำการจองห้องพัก</p>
                                            </a>
                                        <?php } else { ?>
                                            <div class="boxdatablacksmall" style="display: none;">
                                                <p>ทำการจองห้องพัก</p>
                                            </div>
                                        <?php } ?>

                                        <?php if ($difference <= 0) { ?>
                                            <div class="boxdatablacksmallsos">
                                                <p>ห้องพักเต็ม</p>
                                            </div>
                                        <?php } ?>


                                    </div>

                                </div>
                            </div>



                        </div>




                        <div class="room-content rmtwo">


                            <div class="ptroom">
                                <div class="roomone">
                                    <img src="./css/UI/room/2.jpg">
                                    <p>ห้องพักแบบพิเศษ 1 </p>
                                </div>
                            </div>


                            <div class="dataroom">
                                <div class="dataone">

                                    <div class="boxdataall">

                                        <div class="boxdata">
                                            <p>จำนวนห้องว่าง : <?php echo $difference_2; ?> </p>
                                        </div>

                                        <div class="boxdatasmall">
                                            <p>ราคา 500 / คืน</p>
                                        </div>

                                        <?php if ($difference_2 > 0) { ?>
                                            <a href="summit_1.php?room=ห้องพักแบบพิเศษ 1" class="boxdatablacksmall">
                                                <p>ทำการจองห้องพัก</p>
                                            </a>
                                        <?php } else { ?>
                                            <div class="boxdatablacksmall" style="display: none;">
                                                <p>ทำการจองห้องพัก</p>
                                            </div>
                                        <?php } ?>

                                        <?php if ($difference_2 <= 0) { ?>
                                            <div class="boxdatablacksmallsos">
                                                <p>ห้องพักเต็ม</p>
                                            </div>
                                        <?php } ?>



                                    </div>

                                </div>
                            </div>



                        </div>







                        <div class="room-content rmthree">


                            <div class="ptroom">
                                <div class="roomone">
                                    <img src="./css/UI/room/3.jpg">
                                    <p>ห้องพักแบบพิเศษ 2 </p>
                                </div>
                            </div>


                            <div class="dataroom">
                                <div class="dataone">

                                    <div class="boxdataall">

                                        <div class="boxdata">
                                            <p>จำนวนห้องว่าง : <?php echo $difference_3; ?> </p>
                                        </div>

                                        <div class="boxdatasmall">
                                            <p>ราคา 600 / คืน</p>
                                        </div>

                                        <?php if ($difference_3 > 0) { ?>
                                            <a href="summit_1.php?room=ห้องพักแบบพิเศษ 1" class="boxdatablacksmall">
                                                <p>ทำการจองห้องพัก</p>
                                            </a>
                                        <?php } else { ?>
                                            <div class="boxdatablacksmall" style="display: none;">
                                                <p>ทำการจองห้องพัก</p>
                                            </div>
                                        <?php } ?>

                                        <?php if ($difference_3 <= 0) { ?>
                                            <div class="boxdatablacksmallsos">
                                                <p>ห้องพักเต็ม</p>
                                            </div>
                                        <?php } ?>


                                    </div>

                                </div>
                            </div>



                        </div>







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