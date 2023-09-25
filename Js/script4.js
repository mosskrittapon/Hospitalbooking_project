function validateForm() {
    var HN = document.getElementById("HN").value;
    var P_number = document.getElementById("P_number").value;

    if (HN === "" || P_number === "") {
        // แสดงเตือน popup ถ้าข้อมูลไม่ครบ
        window.alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
        return false; // ยกเลิกการ submit ฟอร์ม
    }

    // ถ้าข้อมูลถูกต้อง ส่งฟอร์มไปยังการกระทำที่ต้องการ
    return true;
}
