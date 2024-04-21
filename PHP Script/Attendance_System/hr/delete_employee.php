<?php 
	include_once "./../config.php";
	include_once 'session.php';
	try{
	

	if(isset($_POST['d_employee_id'])){
		$emp_id=$_POST['d_employee_id'];
		$error=0;		

		$create = $conn->prepare("DELETE FROM Employee WHERE EmployeeCode=?");

		$create->execute([
		    $emp_id
		]);
		// $msg='The Selected Section was Successfully Deleted. ';


		$msg='The Selected Employee was Successfully Deleted. ';



		if ($msg) {
			$_SESSION['msg']=$msg;
		} 
		if($error){
			$_SESSION['error']=$error;
		}
		
		//echo($_SESSION['msg']);
	    


	}
	header("location: employee.php");

	}
	catch(PDOException $e){
    $_SESSION['error']="Can't Delete Department because  ".$e->getMessage();
    header("location: employee.php");
	}



 ?>