let currentRoom = 0;
const rooms = document.querySelectorAll('.room-content');

function showRoom(roomName) {
  for (let i = 0; i < rooms.length; i++) {
    rooms[i].classList.remove('show');
    if (rooms[i].classList.contains(roomName)) {
      rooms[i].classList.add('show');
      currentRoom = i;
    }
  }
}

document.querySelector('.room-selector button:first-child').addEventListener('click', () => {
  currentRoom = (currentRoom - 1 + rooms.length) % rooms.length;
  rooms[currentRoom].classList.add('show');
});

document.querySelector('.room-selector button:last-child').addEventListener('click', () => {
  currentRoom = (currentRoom + 1) % rooms.length;
  rooms[currentRoom].classList.add('show');
});

