<?php
require_once('dbcon.php');

require_once('db_register.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital</title>
    <link rel="stylesheet" href="css/style7.css">


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



        <div class="backg">

            <div class="boxregis">


                <div class="formdata">


                    <div class="formtext">
                        <p>กรุณากรอกข้อมูลผู้ป่วยเพื่อใช้สำหรับลงทะเบียนระบบจองห้องพัก</p>
                    </div>

                    <div class="allform_label">
                        <form action="" method="post" onsubmit="return validateForm()">


                            <div class="label_form">
                                <label for="HN">รหัส HN ผู้ป่วยของท่าน :</label>
                                <input type="text" id="HN" name="HN" maxlength="10" placeholder="กรุณาใส่รหัส HN ที่ไม่เกิน 10 หลัก" oninput="this.value = this.value.replace(/[^0-9]/g, '')"><br><br>
                            </div>

                            <div class="label_form">
                                <label for="ID_number">เลขบัตรประชาชน :</label>
                                <input type="text" id="ID_number" name="ID_number" maxlength="13" placeholder="กรุณาใส่เลขบัตรประชาชน 13 หลัก" oninput="this.value = this.value.replace(/[^0-9]/g, '')"><br><br>
                            </div>

                            <div class="label_form">
                                <label for="S_name">ชื่อ-นามสกุล :</label>
                                <input type="text" id="S_name" name="S_name" placeholder="กรุณาใส่ชื่อ-นามสกุล"><br><br>
                            </div>
                            <div class="label_form3">
                                <label for="Department">แผนก :</label>
                                <select id="Department" name="Department">
                                    <option value="" disabled selected>กรุณาเลือกแผนก</option>
                                    <?php
                                    $dp = $conn->query("SELECT * FROM department");
                                    while ($dp_data = $dp->fetch_assoc()) {
                                        $dp_name[$dp_data['d_id']] = $dp_data['d_name'];
                                    ?>
                                        <option value="<?php echo $dp_data['d_name'] ?>"><?php echo $dp_data['d_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    
                                </select><br><br>
                            </div>

                            <div class="label_form">
                                <label for="P_number">เบอร์โทรศัพท์ :</label>
                                <input type="tel" id="P_number" name="P_number" placeholder="กรุณาใส่เบอร์โทรศัพท์" oninput="this.value = this.value.replace(/[^0-9]/g, '')"><br><br>
                            </div>

                            <div class="label_form">
                                <label for="Email">อีเมล :</label>
                                <input type="email" id="Email" name="Email" placeholder="กรุณาใส่ email พร้อมเครื่องหมาย @ "><br><br>
                            </div>

                            <div class="btsubmit">
                                <input type="submit" value="ลงทะเบียน">
                                <a href="main.php" class="cancel">
                                    <p>กลับหน้าหลัก</p>
                                </a>


                            </div>


                        </form>



                    </div>



                </div>





            </div>



        </div>






        <script src="Js/script2.js"></script>

</body>

</html>