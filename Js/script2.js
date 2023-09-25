
// สร้างฟังก์ชัน autoTab เพื่อเลื่อนไปช่องถัดไปเมื่อกรอกครบจำนวนตามที่กำหนด
function autoTab(input, nextField, prevField) {
    if (input.value.length === 0 && prevField) {
        document.getElementById(prevField).focus();
    } else if (input.value.length >= input.maxLength) {
        document.getElementById(nextField).focus();
    }
}






function validateForm() {
  var HN = document.getElementById("HN").value;
  var ID_number = document.getElementById("ID_number").value;
  var S_name = document.getElementById("S_name").value;
  var Department = document.getElementById("Department").value;
  var P_number = document.getElementById("P_number").value;
  var Email = document.getElementById("Email").value;

  // ตรวจสอบว่าทุกช่องถูกกรอกหรือไม่
  if (HN === "" || ID_number === "" || S_name === "" || Department === "" || P_number === "" || Email === "") {
    alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
    return false; // ยกเลิกการ submit ฟอร์ม
  }
  
  alert("ลงทะเบียนสำเร็จ"); // แจ้งเตือนลงทะเบียนสำเร็จ
  
  // เปลี่ยนเส้นทางไปยังหน้า main.php
  window.location.href = "main.php";
  
  return true; // ยอมรับการ submit ฟอร์ม
}



$(document).ready(function() {
    $("#HN").on("input", function() {
        var HN = $(this).val();
        if (HN !== "") {
            // ส่งค่า HN ไปที่ PHP script เพื่อดึงข้อมูลจากฐานข้อมูล
            $.ajax({
                type: "POST",
                url: "db_submit.php", // เปลี่ยน URL นี้เป็นชื่อไฟล์ใหม่
                data: { HN: HN },
                success: function(data) {
                    // อัพเดทข้อมูลในฟอร์ม
                    var jsonData = JSON.parse(data);
                    $("#ID_number").val(jsonData.ID_number);
                    $("#S_name").val(jsonData.S_name);
                    // หากมีข้อมูลอื่น ๆ ที่ต้องการแสดงในฟอร์มเพิ่มตรงนี้
                }
            });
        } else {
            // ให้ล้างข้อมูลในฟอร์มเมื่อไม่มีค่า HN
            $("#ID_number").val("");
            $("#S_name").val("");
            // หากมีข้อมูลอื่น ๆ ที่ต้องการล้างเพิ่มตรงนี้
        }
    });
});