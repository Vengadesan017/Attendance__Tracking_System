<?php
    
    session_start();
   
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>  
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" type="text/css" href="css/error.css">
    <link rel="icon" type="image/png" href="img/favicon.png">
</head>

<body>

    <header>

        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="136" height="68" viewBox="0 0 136 68"> <defs> <linearGradient id="c" x1="0%" x2="100%" y1="50%" y2="50%"> <stop offset="0%" stop-color="#1D4C84"></stop> <stop offset="100%" stop-color="#1474A4"></stop> </linearGradient> <filter id="b" width="122.8%" height="145.6%" x="-12.1%" y="-16.9%" filterUnits="objectBoundingBox"> <feOffset dx="-1" dy="4" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset> <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation="4.5"></feGaussianBlur> <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.48 0"></feColorMatrix> </filter> <rect id="a" width="136" height="68" x="0" y="0"></rect> </defs> <g fill="none" fill-rule="evenodd"> <use xlink:href="#a" fill="#000" filter="url(#b)"></use> <use xlink:href="#a" fill="#FFF"></use> <rect width="136" height="68" fill="url(#c)"></rect> <path fill="#FFF" d="M0,0 L136,0 L136,38.6666667 C136,51.8741117 126.951872,60 106.790056,60 L0,60 L0,0 Z"></path> <path fill="#0B5ED7" d="M99,36.0007987 L96,36.0007987 L96,41 L90,41 L90,20.0075528 C90.8,19.990559 95.525,20.0075528 98,20.0075528 C104.398,20.0075528 107.999,22.3017274 107.999,28.0036759 C107.999,33.1958079 104.801,36.0007987 99,36.0007987 Z M97,24.0075556 C96.68,24.0075556 96.363,23.9855556 96,24.0075556 L96,32.0065556 L97,32.0065556 C100.241,32.0065556 101.999,30.6465556 101.999,28.0065556 C101.999,25.4525556 100.72,24.0075556 97,24.0075556 Z M79,20 L85,20 L85,41 L79,41 L79,20 Z M65,41 L65,20 L71,20 L71,37 L77,37 L76,41 L65,41 Z M54,20 L60,20 L60,41 L54,41 L54,20 Z M42.999,31.999 L36.999,31.999 L36.999,41 L31,41 L31,20 L36.999,20 L36.999,27.999 L42.999,27.999 L42.999,20 L49,20 L49,41 L42.999,41 L42.999,31.999 Z M19.0005,36.0007987 L15.9993333,36.0007987 L15.9993333,41 L10,41 L10,20.0075528 C10.8000444,19.990559 15.525307,20.0075528 17.9994444,20.0075528 C24.3987999,20.0075528 28,22.3017274 28,28.0036759 C28,33.1958079 24.8018223,36.0007987 19.0005,36.0007987 Z M118.714629,20 C121.417856,20 123.5,20.5 125,21 L125,21 L125,25 C123.517791,24.409475 121.417856,23.9636607 119.412091,23.9636607 C117.581234,23.9636607 116,24 116,25.5 C116,27.3709677 118.187825,27.9399294 120.5168,28.7059931 L121,28.8677931 C123.5,29.7233721 126,30.9223157 126,34.2957746 C126,39.3561247 122.115317,41 116.796319,41 C114.703601,41 111.918311,40.6750473 110,40 L110,40 L110,36 C111.918311,36.9276446 114.407282,37 116.5,37 C118.854245,37 120.022599,36.2769312 120.022599,35.0120054 C120.022599,31.7227455 110.082231,33.1563929 110.082231,26.0720321 C110.082231,21.9606594 113.570038,20 118.714629,20 Z M15.999,24.0075556 C16.363,23.9855556 16.68,24.0075556 17,24.0075556 C20.71,24.0075556 21.999,25.4525556 21.999,28.0065556 C21.999,30.6465556 20.241,32.0065556 17,32.0065556 L17,32.0065556 L15.999,32.0065556 Z"></path> </g> </svg>


        </div>
    </header>

    <div class="wrapper">
        
        <div class="form-box login">
            <h2>Login</h2>
            <form name="form1" id='form' method="post" action="<?php echo htmlspecialchars('authentication.php'); ?>">
                <?php
                        if (isset($_SESSION['error'])) {
                            
            echo " <div class='alert alert-danger alert-dismissible text-center'>
                                ".$_SESSION['error']."<div class='close'>&times;</div>
                            </div>
                        ";
                            unset($_SESSION['error']);
                        }
                        elseif (isset($_SESSION["username"])) {
                            header("location: logout.php");
                        }
                        elseif (isset($_SESSION['user_id'])) {
                              header("location: logout.php"); 
                           }

                ?>
                <div class="input-box">
                    <input type="text" id="username" name="username" class="form-control" id="username"required>
                    <label>Username</label>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <label>Password</label>
                </div>
<!--                 <div class="forgot">                    
                    <a href="#">Forgot Password?</a>
                </div> -->
                <button type="submit" name="submit" class="btn">Login</button>
            </form>

        </div>
    </div>


    <script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
  var closeButtons = document.querySelectorAll(".alert.alert-dismissible .close");
  for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].addEventListener("click", function() {
      var alertDiv = this.parentElement;
      alertDiv.style.display = "none";
    });
  }
});
    </script>
</body>

</html>
