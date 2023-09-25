<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital</title>
    <link rel="stylesheet" href="css/style1-1.css">
    <link rel="stylesheet" href="css/style6-1.css">
    <link rel="stylesheet" href="css/style5-1.css">

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

                <div class="formsearch">
                    <form method="POST" action="">
                        <label for="hn_search"> กรุณาใส่รหัส HN เพื่อค้นหา  </label>
                        <input type="text" name="hn_search" id="hn_search" value="<?php echo isset($hn_search) ? $hn_search : ''; ?>">
                        <input type="submit" value="ค้นหา">
                    </form>
                


                    <div class="dbsearch">

                        <?php

                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "hospital";

                        // สร้างการเชื่อมต่อ
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // ตรวจสอบการเชื่อมต่อ
                        if ($conn->connect_error) {
                            die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
                        }

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $hn_search = $_POST["hn_search"];
                            // ปรับเปลี่ยนคำสั่ง SQL เพื่อใช้เงื่อนไขค้นหา
                            $sql = "SELECT * FROM book WHERE HN = '$hn_search';";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                // แสดงข้อมูลที่ค้นหาเจอในตาราง
                                echo "<table border='1'>";
                                echo "<tr>";
                                echo "<th font-size: 18px;'>HN ผู้ป่วย</th>";
                                echo "<th font-size: 18px;'>ชื่อ-นามสกุล (ผู้ป่วย)</th>";
                                echo "<th font-size: 18px;'>แผนก</th>";
                                echo "<th font-size: 18px;'>ชื่อ-นามสกุล (ผู้จอง)</th>";
                                echo "<th font-size: 18px;'>ประเภทห้องพัก</th>";
                                echo "<th font-size: 18px;'>สถานะการจอง</th>";
                                echo "</tr>";
                                
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['HN'] . "</td>";
                                    echo "<td>" . $row['S_name'] . "</td>";
                                    echo "<td>" . $row['Department'] . "</td>";
                                    echo "<td>" . $row['booked_by'] . "</td>";
                                    echo "<td>" . $row['room'] . "</td>";
                                    echo "<td>" . $row['Status'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                // ตรวจสอบว่า $hn_search ไม่ว่างเปล่า (ไม่มีข้อมูลในกล่องข้อความ)
                                if (!empty($hn_search)) {
                                    echo "<script>
                                        alert('ไม่พบข้อมูลที่ค้นหา กรุณาตรวจสอบรหัส HN ใหม่อีกครั้ง');
                                        setTimeout(function() {
                                            window.location.href = 'check.php';
                                        }, 3000); // 3 วินาที
                                    </script>";
                                }
                            }
                        }
                        ?>

                    </div>
                </div>





            </div>









        </div>








</body>

</html>