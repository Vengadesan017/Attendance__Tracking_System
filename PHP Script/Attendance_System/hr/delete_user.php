<?php 
	include_once "./../config.php";
	include_once 'session.php';
	try{
	

	if(isset($_GET['user_id'])){
		$user_id=$_GET['user_id'];
			
	$error=0;
	$delete_user = $conn->prepare("DELETE FROM [User] WHERE user_id=?");

	$delete_user->execute([
	    $user_id
	]);
	$msg='The user is Successfully Deleted. ';
	$dep=is_dep($user_id);
	$sec=is_sec($user_id);
	$con=is_con($user_id);
	if ($dep) {
		foreach ($dep as $key) {

		//$_SESSION['error']=(is_dep($user_id))['department_name'];
			$delete_map = $conn->prepare("UPDATE [Department] SET user_id=0 WHERE id=?");

			$delete_map->execute([
			    $key['id']
			]);
			$msg.='The Deleted user is mapped with '.$key['department_name'].' Department Now it is unmapped Successfully';
		}
	} 
	if($sec){
		foreach ($sec as $key) {

			//$_SESSION['error']=(is_sec($user_id))['Section_name'];

			$delete_map = $conn->prepare("UPDATE [Section] SET user_id=0 WHERE id=?");

			$delete_map->execute([
			    $key['id']
			]);
			$msg.='The Deleted user is mapped with '.$key['Section_name'].' in '.$key['department_name'].' Now it is unmapped Successfully.';
		}
	}
	if ($con) {
				$create = $conn->prepare("DELETE FROM Contractor WHERE Contractor_id=?");
		    	$create->execute([$user_id]);		
	}

	if ($msg) {
		$_SESSION['msg']=$msg;
	} 
	if($error){
		$_SESSION['error']=$error;
	}
	
		
	

	    header("location: user.php");

	}

	}
	catch(PDOException $e){
    $error="Can't Delete User because  ".$e->getMessage();
	if ($msg) {
		$_SESSION['msg']=$msg;
	}
	if($error){
		$_SESSION['error']=$error;
	}
    header("location: user.php");
	}


	function is_dep($userId){
		global $conn;
		$fetch_query="SELECT *
						FROM [Department]
						WHERE user_id=$userId";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql=$conn->prepare($fetch_query);
		$sql->execute();
        $row_count=$sql->rowCount();
        if ($row_count==0){
            return 0;
        }
        else{
            $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
            $dep_id=$sql->fetchAll();
            return $dep_id;
        }

       }
	function is_sec($userId){
		global $conn;
		$fetch_query="SELECT s.*, s.Section_name,d.department_name 
						FROM [Section] s
						INNER JOIN [Department] d ON d.department_id=s.department_id 
						WHERE s.user_id=$userId";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql=$conn->prepare($fetch_query);
		$sql->execute();
        $row_count=$sql->rowCount();
        if ($row_count==0){
            return 0;
        }
        else{
            $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
            $dep_id=$sql->fetchAll();
            return $dep_id;
        }

       }
	function is_con($userId){
		global $conn;
		$fetch_query="SELECT Contractor_id,Contractor_name FROM Contractor WHERE Contractor_id=$userId";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql=$conn->prepare($fetch_query);
		$sql->execute();
        $row_count=$sql->rowCount();
        if ($row_count==0){
            return 0;
        }
        else{
            $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
            $dep_id=$sql->fetchAll();
            return $dep_id;
        }

       }

 ?>