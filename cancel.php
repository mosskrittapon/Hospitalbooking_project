<?php 
    require_once 'db_cancel.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital</title>
    <link rel="stylesheet" href="css/style7-cancel.css">


    <style>        
        body{ margin: 0; }     
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
                            <p>กรุณากรอก HN และ เบอร์โทรศัพท์ผู้จอง เพื่อใช้สำหรับการยกเลิกจองห้องพัก</p>
                        </div>

                        <div class="allform_label">
                                <form action="#" method="post" onsubmit="return validateForm()">

                                        <div class="label_form">
                                            <label for="HN">รหัส HN ผู้เข้าพัก :</label>
                                            <input type="text" id="HN" name="HN" maxlength="10" onkeyup="searchHN()" placeholder="กรุณาใส่รหัส HN ที่ไม่เกิน 10 หลัก" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            <span id="hn_error" style="color: red;"></span>
                                            <br><br>
                                        </div>


                                        
                                        <div class="label_form">
                                            <label for="P_number">เบอร์โทรศัพท์ ผู้จอง :</label>
                                            <input type="tel" id="P_number" name="P_number" placeholder="กรุณาใส่เบอร์โทรศัพท์" oninput="this.value = this.value.replace(/[^0-9]/g, '')" ><br><br>
                                        </div>


                                        <div class="btsubmit">
                                            <input type="submit" value="ยืนยัน">
                                            <a href="main.php" class="cancel">
                                                <p>กลับหน้าหลัก</p>
                                            </a>
                                            

                                        </div>

                                </form>


                                
                        </div>



                    </div>




                    
                </div>



            </div>    






 <script src="Js/script4.js"></script>
            
</body>
</html>