
// สร้างฟังก์ชัน autoTab เพื่อเลื่อนไปช่องถัดไปเมื่อกรอกครบจำนวนตามที่กำหนด
function autoTab(input, nextField, prevField) {
    if (input.value.length === 0 && prevField) {
        document.getElementById(prevField).focus();
    } else if (input.value.length >= input.maxLength) {
        document.getElementById(nextField).focus();
    }
}


function validateForm() {
  var appointment_date = document.getElementById("appointment_date").value;  
  var HN = document.getElementById("HN").value;
  var ID_number = document.getElementById("ID_number").value;
  var S_name = document.getElementById("S_name").value;
  var booked_by = document.getElementById("booked_by").value;
  var Department = document.getElementById("Department").value;
  var P_number = document.getElementById("P_number").value;
  var Email = document.getElementById("Email").value;

  // ตรวจสอบว่าทุกช่องถูกกรอกหรือไม่
  if ( appointment_date === "" || HN === "" || ID_number === "" || S_name === "" || booked_by ==="" || Department === "" || P_number === "" || Email === "" ) {
    alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
    return false; // ยกเลิกการ submit ฟอร์ม
  }

 
  //  alert("ลงทะเบียนสำเร็จ"); // แจ้งเตือนลงทะเบียนสำเร็จ
  
  // เปลี่ยนเส้นทางไปยังหน้า main.php
  window.location.href = "confirm.php";
  
  return true; // ยอมรับการ submit ฟอร์ม
}

function validateAppointmentDate() {
    var currentDate = new Date(); // วันและเวลาปัจจุบัน
    var appointmentDate = new Date(document.getElementById("appointment_date").value);

    if (appointmentDate < currentDate) {
        alert("ไม่สามารถเลือกวันที่ผ่านมาแล้วได้");
        document.getElementById("appointment_date").value = ""; // ลบค่าที่ผู้ใช้เลือก
    }
}




function searchHN() {
    var HN = document.getElementById("HN").value;

    // ส่งคำสั่งไปยังเซิร์ฟเวอร์เพื่อค้นหาข้อมูล
    if (HN !== '') {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // รับข้อมูล JSON ที่ส่งกลับมาจากเซิร์ฟเวอร์และแสดงผล
                var data = JSON.parse(xhr.responseText);
                document.getElementById("ID_number").value = data.ID_number;
                document.getElementById("S_name").value = data.S_name;
                document.getElementById("booked_by").value = data.booked_by;
                document.getElementById("Department").value = data.Department;
            }
        };
        xhr.open("POST", "db_join.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("HN=" + HN);
    } else {
        // ล้างข้อมูลในฟอร์มเมื่อไม่มี HN
        document.getElementById("ID_number").value = '';
        document.getElementById("S_name").value = '';
        document.getElementById("booked_by").value = '';
        document.getElementById("Department").value = '';
    }
}



function searchHN() {
    var HN = document.getElementById("HN").value;

    // ส่งคำสั่งไปยังเซิร์ฟเวอร์เพื่อค้นหาข้อมูล
    if (HN !== '') {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // รับข้อมูล JSON ที่ส่งกลับมาจากเซิร์ฟเวอร์และแสดงผลแบบเรียลไทม์
                var data = JSON.parse(xhr.responseText);
                if (data.found) {
                    document.getElementById("ID_number").value = data.ID_number;
                    document.getElementById("S_name").value = data.S_name;
                    document.getElementById("Department").value = data.Department;
                } else {
                    // ไม่พบข้อมูลสำหรับ HN ที่ระบุ
                    document.getElementById("ID_number").value = '';
                    document.getElementById("S_name").value = '';
                    document.getElementById("Department").value = '';
                }
            }
        };
        xhr.open("POST", "db_join.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("HN=" + HN);
    } else {
        // ล้างข้อมูลในฟอร์มเมื่อไม่มี HN
        document.getElementById("ID_number").value = '';
        document.getElementById("S_name").value = '';
        document.getElementById("Department").value = '';
    }
}



