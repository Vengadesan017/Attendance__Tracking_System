 <?php 
	include_once "session.php"; 
	include_once "./../config.php";
	try{
	

	if(isset($_POST['edit'])){
		$dep_id=$_POST['e_department_id'];
		$dep_name=$_POST['e_department_name'];
		$manager_id = $_POST['manager_name'];


		$b_dep_name=$_POST['before_e_department_name'];
		$b_manager_id = $_POST['before_e_manager_id'];


		if ($dep_name!==$b_dep_name){
			
			$edit = $conn->prepare("UPDATE [Department] SET department_name= ? WHERE department_id= ?");
    		$edit->execute([$dep_name,$dep_id]);
		} 
		if ($manager_id!==$b_manager_id) {
			$edit = $conn->prepare("UPDATE [Department] SET user_id=? WHERE department_id=?");
    		$edit->execute([$manager_id,$dep_id]);	
		}
		
	    header("location: department.php");

	}

	}
	catch(PDOException $e){
    $_SESSION['error']="Can't Edit Department because  ".$e->getMessage();
    header("location: department.php");
	}

		



?>