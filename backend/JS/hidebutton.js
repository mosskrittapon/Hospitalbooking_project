function password_show_hide(targetElement, showEyeID, hideEyeID) {
  var x = document.getElementById(targetElement);
  var show_eye = document.getElementById(showEyeID);
  var hide_eye = document.getElementById(hideEyeID);
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
