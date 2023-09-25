    // รับค่าหมายเลขห้องจาก URL
    const params = new URLSearchParams(window.location.search);
    const roomNumber = params.get("room");

    // กำหนดค่าหมายเลขห้องลงในฟอร์ม
    document.getElementById("room").value = roomNumber;