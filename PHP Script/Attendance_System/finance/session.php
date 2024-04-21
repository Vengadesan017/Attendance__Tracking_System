<?php
	
    session_start();

	if (isset($_SESSION['financer'])){
		
		$now = time();
      
        if($now > $_SESSION['expire']) {
            header("Location: ./../logout.php");  
        }
	}
	else {
		header("location: ./../index.php");
	}   
?>