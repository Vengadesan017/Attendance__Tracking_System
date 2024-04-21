<?php
	
    session_start();

	if (isset($_SESSION['contractor'])){
		
		$now = time();
      
        if($now > $_SESSION['expire']) {
            header("Location: ./../logout.php");  
        }
	}
	else {
		header("location: ./../index.php");
	}   
?>