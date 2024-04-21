<?php 
	include_once "./../config.php";
	include_once 'session.php';

	if(isset($_GET['dep_id'])){

		$dep_id=$_GET['dep_id'];



		$sql = "SELECT *
				FROM [Section]
				WHERE department_id=?";
		$stmt = $conn->prepare($sql);
		try {
		$stmt->execute([$dep_id]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    $_SESSION['error']=$e->getMessage();
		}
		

		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	try{
	if(isset($_POST['edit'])){

		$e_emp_id=$_POST['e_employee_id'];

		// $emp_fname=$_POST['e_f_employee_name'];
		// $emp_lname=$_POST['e_l_employee_name'];	
		$loc_id = $_POST['location_name'];
		$div_id = $_POST['division_name']; 			
		$dep_id = $_POST['department_name'];
		$sec_id = $_POST['section_name'];
		$con_id = $_POST['contractor_name'];
		$a_flag = $_POST['a_flag'];


		// $b_emp_fname=$_POST['before_e_f_employee_name'];
		// $b_emp_lname=$_POST['before_e_l_employee_name'];
		$b_loc_id=$_POST['before_e_location_id'];
		$b_div_id=$_POST['before_e_division_id'];		
		$b_dep_id=$_POST['before_e_department_id'];
		$b_sec_id=$_POST['before_e_section_id'];
		$b_con_id=$_POST['before_e_contractor_id'];
		$before_a_flag=$_POST['before_a_flag'];
		// $b_sec_name=$_POST['before_e_section_id'];




		if ($loc_id!==$b_loc_id) {

			$edit = $conn->prepare("UPDATE Employee SET Location_id=? WHERE EmployeeCode=?");
    		$edit->execute([$loc_id,$e_emp_id]);	
		}

		if ($div_id !== $b_div_id) {

		    $edit = $conn->prepare("UPDATE Employee SET Division_id=? WHERE EmployeeCode=?");
		    $edit->execute([$div_id, $e_emp_id]);	
		}

		if ($dep_id!==$b_dep_id) {

			$edit = $conn->prepare("UPDATE Employee SET Department_id=? WHERE EmployeeCode=?");
    		$edit->execute([$dep_id,$e_emp_id]);	
		}

		if ($sec_id !== $b_sec_id) {

		    $edit = $conn->prepare("UPDATE Employee SET Section_id=? WHERE EmployeeCode=?");
		    $edit->execute([$sec_id, $e_emp_id]);	
		}

		if ($con_id!==$b_con_id) {

			$edit = $conn->prepare("UPDATE Employee SET Contractor_id=? WHERE EmployeeCode=?");
    		$edit->execute([$con_id,$e_emp_id]);	
		}

	

		if ($a_flag!==$before_a_flag) {

			$edit = $conn->prepare("UPDATE Employee SET a_flag=? WHERE EmployeeCode=?");
    		$edit->execute([$a_flag,$e_emp_id]);	
		}



	    header("location:employee.php");
	}

	}
	catch(PDOException $e){
    $_SESSION['error']="Can't Edit Employee Because  ".$e->getMessage();
    header("location: employee.php");
	}

 ?>

