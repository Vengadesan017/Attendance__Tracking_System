<?php
	include_once "session.php";
	include_once "./../config.php";
	try {
		if (isset($_POST['create'])) {
			$user_id = $_POST['user_id'];
			$user_name = $_POST['user_name'];
			$user_department = $_POST['user_department'];
			$user_login = (int)$_POST['user_login'];
			$password = 'qwerty@123';

			$create = $conn->prepare("INSERT INTO [User] (user_id, username, password, department, login_id) VALUES (?, ?, ?, ?, ?)");

			$create->execute([$user_id, $user_name, password_hash($password, PASSWORD_DEFAULT), $user_department, $user_login]);

			$_SESSION['msg'] = 'The New User ' . $user_name . ' was Created Successfully';
			header("location: user.php");

			if ($user_login == 3) {
				$create = $conn->prepare("INSERT INTO Contractor (Contractor_id, Contractor_name) VALUES (?, ?)");
				$create->execute([$user_id, $user_name]);
			}
		}
	} catch (PDOException $e) {
		$_SESSION['error'] = "Can't Create New User because: " . $e->getMessage();
		header("location: user.php");
	}

	function display() {
		global $conn;
		$fetch_query = "SELECT u.user_id, u.username, u.department, u.login_id,l.login_name FROM [User] u LEFT JOIN [Login] l ON u.login_id=l.login_id";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $conn->prepare($fetch_query);
		$sql->execute();
		$users = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $users;
	}
	function display_login() {
	    global $conn;
	    $fetch_query = "SELECT e.EmployeeCode, e.employee_name, d.department_name FROM Employee e LEFT JOIN Department d ON e.Department_id = d.department_id WHERE is_working = ?";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute(['Working']);
	    $users = $sql->fetchAll(PDO::FETCH_ASSOC);

	    $formattedData = array();
	    foreach ($users as $user) {
	        $userCode = $user['EmployeeCode'];
	        $formattedData[$userCode] = array(
	            'name' => $user['employee_name'],
	            'department' => $user['department_name']
	        );
	    }

	    return $formattedData;
	}


?>
