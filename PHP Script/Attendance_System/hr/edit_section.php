 <?php 
	include_once "session.php"; 
	include_once "./../config.php";
	try{
	if(isset($_POST['edit'])){

		$before_e_section_id=$_POST['before_e_section_id'];
		$before_e_department_id=$_POST['before_e_department_id'];
		$before_e_division_id = $_POST['before_e_division_id'];
		$before_e_location_id = $_POST['before_e_location_id'];

		$before_e_manager_id=$_POST['before_e_manager_id'];
		$before_e_leader_id=$_POST['before_e_leader_id'];


		$section_name=$_POST['section_name'];
		$department_name=$_POST['department_name1'];
		$divsion_name = $_POST['divsion_name'];
		$location_name = $_POST['location_name1'];
		
		$manager_name=$_POST['manager_name'];
		$leader_name=$_POST['leader_name'];



		if ($section_name!==$before_e_section_id){
			$edit = $conn->prepare("UPDATE [Section] SET department_id=? WHERE Section_id=?");
    		$edit->execute([$department_name,$section_name]);
		} 

		if ($department_name!=$before_e_department_id){
			$edit = $conn->prepare("UPDATE [Section] SET department_id=? WHERE Section_id=?");
    		$edit->execute([$department_name,$section_name]);
    		
		} 

		if ($divsion_name!=$before_e_division_id){
			$edit = $conn->prepare("UPDATE [Department] SET division_id=? WHERE department_id=?");
    		$edit->execute([$divsion_name,$department_name]);
		} 

		if ($location_name!=$before_e_location_id){
			$edit = $conn->prepare("UPDATE [Division] SET location_id=? WHERE division_id=?");
    		$edit->execute([$location_name,$divsion_name]);
		} 





		// if ($location_name!==$before_e_location_id){
		// 	$edit = $conn->prepare("UPDATE [Division] SET location_id=? WHERE division_id=?");
  //   		$edit->execute([$location_name,$divsion_name]);
		// } 

		// if ($divsion_name!==$before_e_division_id){
		// 	$edit = $conn->prepare("UPDATE [Department] SET division_id=? WHERE department_id=?");
  //   		$edit->execute([$divsion_name,$department_name]);
		// } 

		// if ($department_name!==$before_e_department_id){
		// 	$edit = $conn->prepare("UPDATE [Section] SET department_id=? WHERE section_name=?");
  //   		$edit->execute([$department_name,$section_name]);
		// } 
						
		// if ($section_name!==$before_e_section_id){
		// 	$edit = $conn->prepare("UPDATE [Section] SET department_id=? WHERE Section_id=?");
  //   		$edit->execute([$department_name,$section_name]);
		// } 







		
		if ($before_e_manager_id!=$manager_name) {
			$edit = $conn->prepare("UPDATE [Department] SET user_id=? WHERE department_id=?");
    		$edit->execute([$manager_name,$department_name]);	
		}

		if ($before_e_leader_id!=$leader_name) {
			$edit = $conn->prepare("UPDATE [Section] SET user_id=? WHERE Section_id=?");
    		$edit->execute([$leader_name,$section_name]);	
		}



		
	    header("location: workflow.php");
	}

	}
	catch(PDOException $e){
		 // $_SESSION['error']="  ".$b_leader_id;
    $_SESSION['error']="Error at ".$e->getMessage();
    header("location: workflow.php");
	}




?>