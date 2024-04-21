<?php
	include_once "session.php";
	include_once "./../config.php";
	try {
		if (isset($_POST['CreateSection'])) {
			$section_name = $_POST['section_name'];
			$department_name = $_POST['department_name'];			

			$error = 0;

			$create = $conn->prepare("INSERT INTO [Section] (Section_name, department_id,user_id) VALUES ( ?, ?,?)");
			$create->execute([ $section_name,$department_name,0]);

			$msg = 'The ' . $section_name . ' Section was Successfully Created. ';


			if ($msg) {
				$_SESSION['msg'] = $msg;
			}

		}
		else if (isset($_POST['CreateDepartment'])) {
			$department_name = $_POST['department_name'];
			$division_name = $_POST['division_name'];
			$error = 0;

			$create = $conn->prepare("INSERT INTO [Department] (department_name,division_id,user_id) VALUES ( ?, ?, ?)");
			$create->execute([ $department_name,$division_name,0]);

			$msg = 'The ' . $department_name . ' Department was Successfully Created. ';


			if ($msg) {
				$_SESSION['msg'] = $msg;
			}

		}
		else if (isset($_POST['CreateDivision'])) {
			$division_name = $_POST['division_name'];
			$location_name = $_POST['location_name'];
			$error = 0;

			$create = $conn->prepare("INSERT INTO [Division] (division_name, location_id) VALUES ( ?, ?)");
			$create->execute([ $division_name,$location_name]);

			$msg = 'The ' . $division_name . ' Division was Successfully Created. ';


			if ($msg) {
				$_SESSION['msg'] = $msg;
			}

		}

		else if (isset($_POST['CreateLocation'])) {
			$location_name = $_POST['location_name'];

			$error = 0;

			$create = $conn->prepare("INSERT INTO [Location] (location_name) VALUES ( ?)");
			$create->execute([ $location_name]);

			$msg = 'The ' . $location_name . ' Location was Successfully Created. ';


			if ($msg) {
				$_SESSION['msg'] = $msg;
			}

		}

		header("location: workflow.php");
	} catch (PDOException $e) {
		$_SESSION['error'] = "Error at  " . $e->getMessage();
		header("location: workflow.php");
	}
?>
