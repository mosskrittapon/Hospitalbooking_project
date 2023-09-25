<?php
    // สร้างการเชื่อมต่อกับฐานข้อมูล
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


    $sql = "SELECT COUNT(*) as room1 FROM book WHERE room = 'ห้องพักแบบประหยัด'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $room1Count = $row['room1'];
        
        // คำนวณความต่าง
        $difference = 5 - $room1Count;
    }    

    $total_rows_2 = 5;
    $sql = "SELECT COUNT(*) as room2 FROM book WHERE room = 'ห้องพักแบบพิเศษ 1'";
    $result = $conn->query($sql);
    $difference_2 =  5 - $total_rows_2;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $room2Count = $row['room2'];
        
        // คำนวณความต่าง
        $difference_2 = 5 - $room2Count;
        

    }    

    $total_rows_3 = 5;
    $sql = "SELECT COUNT(*) as room3 FROM book WHERE room = 'ห้องพักแบบพิเศษ 2'";
    $result = $conn->query($sql);
    $difference_3 =  5 - $total_rows_3;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $room3Count = $row['room3'];
        
        // คำนวณความต่าง
        $difference_3 = 5 - $room3Count;
        

    }    













?>