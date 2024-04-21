<?php
	include_once "session.php";
	include_once "./../config.php";
	try {
		if (isset($_POST['create'])) {
			$emp_id = $_POST['emp_id'];
			$emp_f_name = $_POST['emp_f_name'];
			$emp_l_name = $_POST['emp_l_name']; 
			$emp_email = $_POST['emp_email'];

			$create = $conn->prepare("INSERT INTO Employee (employee_id, f_name, l_name, email) VALUES (?, ?, ?, ?)");

			$create->execute([$emp_id, $emp_f_name, $emp_l_name, $emp_email]);

			$_SESSION['msg'] = 'The New Employee ' . $emp_f_name . ' ' . $emp_l_name . ' was Created Successfully';
			header("location: employee.php");
		}
	} catch (PDOException $e) {
		$_SESSION['error'] = "Can't Create New User because: " . $e->getMessage();
		header("location: employee.php");
	}

	function display() {
		global $conn;
		$fetch_query = "SELECT user_id, username, email, login_id FROM [User]";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $conn->prepare($fetch_query);
		$sql->execute();
		$users = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $users;
	}

	function login_type($login_id) {
		global $conn;
		$fetch_query = "SELECT login_name FROM [Login] WHERE login_id = ?";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $conn->prepare($fetch_query);
		$sql->execute([$login_id]);
		$login_type = $sql->fetch(PDO::FETCH_ASSOC);
		return $login_type['login_name'];
	}
?>
