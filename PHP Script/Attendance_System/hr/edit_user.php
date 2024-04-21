 <?php 
	include_once "session.php"; 
	include_once "./../config.php";
	try{
	

	if(isset($_POST['edit'])){
		$user_id=$_POST['e_user_id'];
		$user_name=$_POST['e_user_name'];
		$user_department=$_POST['e_user_department'];
		$before_user_login=(int)$_POST['before_e_user_login'];
		$user_login=(int)$_POST['e_user_login'];
		$reset_password = isset($_POST['reset_password']) ? true : false;
		$password='qwerty@123';

		if ($reset_password) {
			$password='qwerty@123';
			$edit = $conn->prepare("UPDATE [User] SET username=?,password=? , department=? ,login_id=? WHERE user_id=?");
    		$edit->execute([$user_name,password_hash($password, PASSWORD_DEFAULT),$user_department,$user_login,$user_id]);
		} else {
			$edit = $conn->prepare("UPDATE [User] SET  username=?,department=? ,login_id=? WHERE user_id=?");
    		$edit->execute([$user_name,$user_department,$user_login,$user_id]);	
		}
		if ($user_login==3 || $before_user_login==3) {
			if ($before_user_login==3 && $user_login==3) {
				
			}			
			elseif ($before_user_login==3) {
				$create = $conn->prepare("DELETE FROM Contractor WHERE Contractor_id=?");
		    	$create->execute([$user_id]);				
			}
			elseif ($user_login==3) {
				$create = $conn->prepare("INSERT INTO Contractor(Contractor_id, Contractor_name) VALUES (?,?)");
		    	$create->execute([$user_id, $user_name]);
			}
		}
		
	    header("location: user.php");

	}

	}
	catch(PDOException $e){
    $_SESSION['error']="Can't edit user because  ".$e->getMessage();
    header("location: user.php");
	}




?>