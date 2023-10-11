
    // เพิ่ม Event Listener สำหรับกดปุ่ม Enter ในช่องค้นหา
    var input = document.getElementById('searchInput');
    input.addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            searchHistory();
        }
    });

    function searchHistory() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var table = document.querySelector('.table');

        // ล้างข้อมูลเดิมทั้งหมดในตาราง
        var rows = table.querySelectorAll('tbody tr');
        rows.forEach(function (row) {
            row.style.display = 'none';
        });

        // ค้นหาและแสดงแถวที่ตรงกับข้อมูลที่ค้นหา
        rows.forEach(function (row) {
            var columns = row.querySelectorAll('td');
            columns.forEach(function (column) {
                if (column.textContent.toLowerCase().indexOf(input) > -1) {
                    row.style.display = '';
                }
            });
        });
    }

