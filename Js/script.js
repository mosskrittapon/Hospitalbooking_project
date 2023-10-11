let currentRoom = 0;
const rooms = document.querySelectorAll('.room-content');

// ซ่อนทุกห้องในเริ่มต้น
for (let i = 1; i < rooms.length; i++) {
  rooms[i].classList.remove('show');
}

document.querySelector('.room-selector button:first-child').addEventListener('click', () => {
  rooms[currentRoom].classList.remove('show'); // ซ่อนห้องปัจจุบัน
  currentRoom = (currentRoom - 1 + rooms.length) % rooms.length;
  rooms[currentRoom].classList.add('show'); // แสดงห้องถัดไป
});

document.querySelector('.room-selector button:last-child').addEventListener('click', () => {
  rooms[currentRoom].classList.remove('show'); // ซ่อนห้องปัจจุบัน
  currentRoom = (currentRoom + 1) % rooms.length;
  rooms[currentRoom].classList.add('show'); // แสดงห้องถัดไป
});
