<?php


$serverName = "ServerName";
$database = "Attendance_System";
$username = "UserName";
$password = "PassWord";

try{

	$conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if (!$conn){echo "connection faild";}
	}
catch(PDOException $e){
    echo $e->getMessage();
}
?>	