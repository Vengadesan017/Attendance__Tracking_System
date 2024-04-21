<?php
	include_once "session.php";
	include_once "./../config.php";
	try {
	    if (isset($_POST['create'])) {
	        $department_id = $_POST['department_id'];
	        $department_name = $_POST['department_name'];

	        $error = 0;

	        $create = $conn->prepare("INSERT INTO [Department] (department_name,user_id) VALUES ( ?,?)");
	        $create->execute([$department_name,0]);

	        $msg = 'The ' . $department_name . ' Department was Successfully Created. ';


	        if ($msg) {
	            $_SESSION['msg'] = $msg;
	        }

	    }
	    header("location: department.php");
	} catch (PDOException $e) {
	    $_SESSION['error'] = "Can't create Department because " . $e->getMessage();
	    header("location: department.php");
	}
?>
