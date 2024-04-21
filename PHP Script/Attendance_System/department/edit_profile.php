<?php
	include_once "session.php";
	include_once "./../config.php";
	try {
		if (isset($_POST['edit'])) {
			$user_id = $_SESSION['user_id'];
			$current_password = $_POST['current_password'];
			$new_password = $_POST['new_password'];
			$confirm_new_password = $_POST['confirm_new_password'];
			$file=$_POST['file'];

			$error = 0;
			$msg = 0;

			$login = $conn->prepare("SELECT * FROM [User] WHERE user_id=:x");
			$login->execute([":x" => $user_id]);
			$data = $login->fetch(PDO::FETCH_ASSOC);

			if (password_verify($current_password, $data["password"])) {
				if ($new_password == $confirm_new_password) {
					$edit = $conn->prepare("UPDATE [User] SET password=? WHERE user_id=?");
					$edit->execute([password_hash($new_password, PASSWORD_DEFAULT), $user_id]);
					$msg = "Your password has been changed successfully.";
				} else {
					$error = "Try again, the new password does not match the confirm new password.";
				}
			} else {
				$error = "Try again, that's not your current password.";
			}

			if ($msg) {
				$_SESSION['msg'] = $msg;
			}
			if ($error) {
				$_SESSION['error'] = $error;
			}

			header("location: $file");
			exit;
		}
	} catch (PDOException $e) {
		$error = "Can't edit profile because " . $e->getMessage();
		$_SESSION['error'] = $error;
		if ($msg) {
			$_SESSION['msg'] = $msg;
		}
		header("location: $file");
		exit;
	}
?>
