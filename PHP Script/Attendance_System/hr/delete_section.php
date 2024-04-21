<?php 
	include_once "./../config.php";
	include_once 'session.php';
	try{
	

	if(isset($_POST['Delete'])){

		$msg='';
		if(isset($_POST['d_location_id']) ? true : false){
			$before_d_location_id=$_POST['before_d_location_id'];		
			$delete = $conn->prepare("DELETE FROM [Location] WHERE location_id=?");

			$delete->execute([
			    $before_d_location_id
			]);

			$delete = $conn->prepare("UPDATE [Division] SET location_id=? WHERE location_id=?");

			$delete->execute([-1,
			    $before_d_location_id
			]);

			$msg.='The Selected location was Successfully Deleted. ';

		}

		if(isset($_POST['d_division_id']) ? true : false){
			$before_d_division_id=$_POST['before_d_division_id'];		
			$delete = $conn->prepare("DELETE FROM [Division] WHERE division_id=?");

			$delete->execute([
			    $before_d_division_id
			]);

			$delete = $conn->prepare("UPDATE [Department] SET division_id=? WHERE division_id=?");

			$delete->execute([-1,
			    $before_d_division_id
			]);

			$msg.='The Selected Division was Successfully Deleted. ';

		}


		if(isset($_POST['d_department_id']) ? true : false){
			$before_d_department_id=$_POST['before_d_department_id'];		
			$delete = $conn->prepare("DELETE FROM [Department] WHERE department_id=?");

			$delete->execute([
			    $before_d_department_id
			]);

			$delete = $conn->prepare("UPDATE [Section] SET department_id=? WHERE department_id=?");

			$delete->execute([-1,
			    $before_d_department_id
			]);

			$msg.='The Selected Depatment was Successfully Deleted. ';

		}


		if(isset($_POST['d_section_id']) ? true : false){
			$before_d_section_id=$_POST['before_d_section_id'];		
			$delete = $conn->prepare("DELETE FROM [Section] WHERE Section_id=?");

			$delete->execute([
			    $before_d_section_id
			]);
			$msg.='The Selected Section was Successfully Deleted. ';

		}


		if(isset($_POST['d_manager_id']) ? true : false){
			$before_d_department_id=$_POST['before_d_department_id'];		
			$delete = $conn->prepare("UPDATE [Department] SET user_id=? WHERE department_id=?");

			$delete->execute([0,
			    $before_d_department_id
			]);
			$msg.='The Selected Depatment was Successfully unmaped. ';

		}


		if(isset($_POST['d_leader_id']) ? true : false){
			$before_d_section_id=$_POST['before_d_section_id'];		
			$delete = $conn->prepare("UPDATE [Section] SET user_id=? WHERE Section_id=?");

			$delete->execute([0,
			    $before_d_section_id
			]);
			$msg.='The Selected Section was Successfully unmaped. ';

		}




		if ($msg) {
			$_SESSION['msg']=$msg;
		} 

		
		//echo($_SESSION['msg']);
	    


	}
	header("location: workflow.php");

	}
	catch(PDOException $e){
    $_SESSION['error']="Can't Delete because ".$e->getMessage();
    header("location: workflow.php");
	}



 ?>