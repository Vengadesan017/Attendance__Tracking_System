var diff = parseInt(expire) - parseInt(now);
var interval = parseInt(diff) * 1000;
var current = parseInt(now) + parseInt(diff);

function check_session(a,z) {

  if (a >= z) {
    alert('Session expired. Please log in again.');
    clearInterval(sessionExpiryTimer);
    location.reload();
  } else {
    // Perform any other actions if needed when the session is still active
    // alert(a+'--z'+z+'--'+start+'--diff'+diff+'--interval'+interval);
    interval=5000;
  }
}

var sessionExpiryTimer = setInterval(function() {
  check_session(current, expire);
}, interval);