<?php 
	include_once "./../config.php";
	include_once 'session.php';
	try{
	

	if(isset($_GET['dep_id'])){
		$dep_id=$_GET['dep_id'];
		$error=0;		

		$create = $conn->prepare("DELETE FROM [Department] WHERE department_id=?");

		$create->execute([
		    $dep_id
		]);
		$msg='The Selected Department was Successfully Deleted. ';

		$sec=is_sec($dep_id);

		if($sec){
			foreach ($sec as $key) {

				//$_SESSION['error']=(is_sec($user_id))['Section_name'];

				$delete_map = $conn->prepare("UPDATE [Section] SET department_id=0 WHERE department_id=?");

				$delete_map->execute([
				    $key['id']
				]);
				$msg.='The Deleted Department is mapped with '.$key['Section_name'].' Section . Now it is unmapped Successfully.';
			}
		}

		if ($msg) {
			$_SESSION['msg']=$msg;
		} 
		if($error){
			$_SESSION['error']=$error;
		}
		
		//echo($_SESSION['msg']);
	    


	}
	header("location: department.php");

	}
	catch(PDOException $e){
    $_SESSION['error']="Can't Delete Department because  ".$e->getMessage();
    header("location: department.php");
	}




	function is_sec($depId){
	    global $conn;
	    $fetch_query="SELECT * 
				    FROM [Section] 
				    WHERE department_id=?";
	    $sql=$conn->prepare($fetch_query);
	    $sql->execute([$depId]);
	    $row_count=$sql->rowCount();
	    if ($row_count==0){
	        return 0;
	    }
	    else{
	        $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
	        $sec_id=$sql->fetchAll();
	        return $sec_id;
	    }
	}



 ?>