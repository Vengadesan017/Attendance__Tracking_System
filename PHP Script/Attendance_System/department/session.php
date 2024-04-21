<?php
	
    session_start();

	if (isset($_SESSION['username']) && isset($_SESSION['user_id'])){
		
		$now = time();
      
        if($now > $_SESSION['expire']) {
            header("Location: ./../logout.php");  
        }
	}
	else {
		header("location: ./../index.php");
	}   
?>