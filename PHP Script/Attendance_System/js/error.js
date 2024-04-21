  document.addEventListener("DOMContentLoaded", function() {
  var closeButtons = document.querySelectorAll(".alert.alert-dismissible .close");
  for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].addEventListener("click", function() {
      var alertDiv = this.parentElement;
      alertDiv.style.display = "none";
    });
  }
});