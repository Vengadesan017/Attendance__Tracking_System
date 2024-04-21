<?php
	include_once "./../config.php";
	include_once 'session.php';
	

	function display_department(){
	    global $conn;
	    $fetch_query = "SELECT d.*, u.username 
	                    FROM [Department] d 
	                    LEFT JOIN [User] u ON u.user_id = d.user_id";
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $departments = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $departments;
	}

	function display_section(){
	    global $conn;
	    $fetch_query = "SELECT s.Section_id, s.Section_name, u.username AS section_leader, u.user_id AS leader_id, d.department_name, d.department_id, d.user_id AS department_username_id, uu.username AS department_manager 
	                    FROM [Section] s 
	                    LEFT JOIN [Department] d ON d.department_id = s.department_id 
	                    LEFT JOIN [User] u ON u.user_id = s.user_id 
	                    LEFT JOIN [User] uu ON uu.user_id = d.user_id";
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $sections = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $sections;
	}
	function display_section_WF(){
	    global $conn;
	    $fetch_query = "SELECT l.location_name,dv.division_name,l.location_id,dv.division_id,s.Section_id, s.Section_name, u.username AS section_leader, u.user_id AS leader_id, d.department_name, d.department_id, d.user_id AS department_username_id, uu.username AS department_manager 
	                    FROM [Location] l 
	                    FULL OUTER JOIN [Division] dv ON dv.location_id = l.location_id 
                      	FULL OUTER JOIN [Department] d on d.division_id = dv.division_id   
                      	FULL OUTER JOIN [Section] s on s.department_id = d.department_id
	                    LEFT JOIN [User] u ON u.user_id = s.user_id 
	                    LEFT JOIN [User] uu ON uu.user_id = d.user_id";
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $sections = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $sections;
	}


	function checking_query($id) {
	    global $conn;
	    $placeholders = implode(',', array_fill(0, count($id), '?'));

	    $approve_query = "UPDATE Attendance SET a_status = ?, verified_by = ?, verified_at = ? WHERE id IN ($placeholders)";

	    $params = array('Verified', $_SESSION['admin'], date('Y-m-d H:i:s'));

	    foreach ($id as $value) {
	        $params[] = $value;
	    }

	    $update = $conn->prepare($approve_query);
	    try {
	        $i = 1;
	        foreach ($params as $param) {
	            $update->bindValue($i++, $param);
	        }
	        $update->execute();
	    } catch (PDOException $e) {
	        $_SESSION['error'] = "Error updating data: " . $e->getMessage();
	    }
	}


	function insert_remark($remark, $id){
	    global $conn;
	    $remark_query = "UPDATE Attendance SET remarks=?, remark_by=? WHERE id=?";
	    $pre_remark = $conn->prepare($remark_query);
	    try {
	        $pre_remark->execute([$remark, $_SESSION['username'], $id]);
	    } catch (PDOException $e) {
	        $_SESSION['error'] = "Error inserting data into column: " . $e->getMessage();
	    }
	}

	function ExportFile($records) {
	  $heading = false;
	  $date = $_POST['date'];
	  
	    if(!empty($records))

	    	print_r("\n\t\tDate :$date \t\n\n");
	    	
	      foreach($records as $row) {
	      if(!$heading) {
	        echo implode("\t", array_keys($row)) . "\n";
	        $heading = true;
	      }
	      echo implode("\t", array_values($row)) . "\n";
	      }
	    exit;
	}

	function display_user(){
	    global $conn;
	    $fetch_query = "SELECT user_id, username FROM [User] WHERE login_id=?";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute([1]);
	    $users = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $users;
	}
	function display_loc(){
	    global $conn;
	    $fetch_query = "SELECT location_id, location_name FROM [Location]";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $deps = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $deps;
	}
	function display_div(){
	    global $conn;
	    $fetch_query = "SELECT division_id, division_name,location_id FROM [Division]";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $deps = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $deps;
	}
	function display_dep(){
	    global $conn;
	    $fetch_query = "SELECT department_id, department_name,division_id FROM [Department]";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $deps = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $deps;
	}
	function display_sec(){
	    global $conn;
	    $fetch_query = "SELECT Section_id, Section_name,department_id FROM [Section]";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $secs = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $secs;
	}

	function display_con(){
	    global $conn;
	    $fetch_query = "SELECT Contractor_id, Contractor_name FROM Contractor";
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    $sql->execute();
	    $cons = $sql->fetchAll(PDO::FETCH_ASSOC);

	    return $cons;
	}


function display_employee(){
    global $conn;
    $fetch_query = "SELECT e.*, d.department_name, d.department_id, s.Section_name, s.Section_id, c.Contractor_name,l.*,div.*
                    FROM Employee e
                    LEFT JOIN [Department] d ON e.Department_id = d.department_id
                    LEFT JOIN [Section] s ON e.Section_id = s.Section_id
                    LEFT JOIN Contractor c ON e.Contractor_id = c.Contractor_id
                    LEFT JOIN [Location] l ON e.location_id = l.location_id
                    LEFT JOIN [Division] div ON e.division_id = div.division_id";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $conn->prepare($fetch_query);
    $sql->execute();
    $sections = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    $total = $sql->rowCount();

    $active = "SELECT e.*, d.department_name, d.department_id, s.Section_name, s.Section_id, c.Contractor_name,l.*,div.*
                    FROM Employee e
                    LEFT JOIN [Department] d ON e.Department_id = d.department_id
                    LEFT JOIN [Section] s ON e.Section_id = s.Section_id
                    LEFT JOIN Contractor c ON e.Contractor_id = c.Contractor_id
                    LEFT JOIN [Location] l ON e.location_id = l.location_id
                    LEFT JOIN [Division] div ON e.division_id = div.division_id 
                    WHERE e.is_working='Working'";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = $conn->prepare($active);
    $sql1->execute();
    $sections1 = $sql1->fetchAll(PDO::FETCH_ASSOC);    
    $active1 = $sql1->rowCount();

    
    return [
        'total' => $total,
        'active' => $active1,        
        'sections' => $sections
    ];
}


	if(isset($_GET['from_date']) && isset($_GET['to_date']) && !isset($_GET['sec_id'])){


	$from_date = $_GET['from_date'];
	$to_date = $_GET['to_date'];


	$_SESSION['from_date']=$from_date;
	$_SESSION['to_date']=$to_date;


	$data = ['labels' => [], 'data' => []];
	foreach (display_department() as $value) {
			

		$fetch_query="SELECT d.dates, COUNT(a.a_date) AS row_count
						FROM (
						    SELECT DATEADD(DAY, n, ?) AS dates
						    FROM (
						        SELECT t0.n + t1.n * 10 + t2.n * 100 + t3.n * 1000 + t4.n * 10000 AS n
						        FROM (
						            SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION
						            SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
						        ) AS t0,
						        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION
						            SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
						        ) AS t1,
						        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION
						            SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
						        ) AS t2,
						        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION
						            SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
						        ) AS t3,
						        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION
						            SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
						        ) AS t4
						    ) AS numbers
						    WHERE DATEADD(DAY, n, ?) <= ?
						) AS d
						LEFT JOIN Attendance AS a ON d.dates = a.a_date
						    AND a.employee_id IN (SELECT employee_id FROM Employee WHERE department_id=?)
						    AND a.a_status='Verified' 
						GROUP BY d.dates
						ORDER BY d.dates";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql=$conn->prepare($fetch_query);
		try {
		$sql->execute([$from_date,$from_date,$to_date,$value['department_id']]);
		$x= $sql->setFetchMode(PDO::FETCH_ASSOC);
		$row_count=$sql->fetchAll();
		} catch (PDOException $e) {
		    $_SESSION['error']=$e->getMessage();
		}
		 $data['labels'][] =$value['department_name'];
 		 $data['data'][] =$row_count;

	
	}
		header('Content-Type: application/json');
		echo json_encode($data);	
	}

	if(isset($_GET['date']) && isset($_GET['shift']) && isset($_GET['sec_id']) && isset($_GET['dep_id']) && !isset($_GET['from_date']))
	{

		$Date = $_GET['date'];
		$Shift = $_GET['shift'];
		$sec_id=$_GET['sec_id'];
		$dep_id=$_GET['dep_id'];

		$_SESSION['date']=$Date;
		$_SESSION['shift']=$Shift;
		$_SESSION['sec_ids']=$sec_id;
		$_SESSION['dep_ids']=$dep_id;

		$shift_array = explode(",", $Shift);
		$shift_array = array_map('trim', $shift_array);
		$shift_string = "'" . implode("','", $shift_array) . "'";

		$dep_array = explode(",", $dep_id);
		$dep_array = array_map('trim', $dep_array);
		$dep_string = "'" . implode("','", $dep_array) . "'";

		$sec_array = explode(",", $sec_id);
		$sec_array = array_map('trim', $sec_array);
		$sec_string = "'" . implode("','", $sec_array) . "'";

		$sql = "SELECT a.*,e.EmployeeCode,e.employee_name,e.Category,d.department_name,s.Section_name,shift.Shift_name,c.Contractor_name 
				FROM Attendance a 
				LEFT JOIN Employee e ON a.employee_id = e.employee_id 
				LEFT JOIN [Department] d ON e.Department_id = d.department_id 
				LEFT JOIN [Section] s ON s.Section_id=e.Section_id 
				LEFT JOIN Shift shift ON shift.Shift_id=a.Shift_id 
				LEFT JOIN Contractor c ON e.Contractor_id=c.Contractor_id 
				WHERE e.Section_id IN ($sec_string) AND a.a_date=? AND a.Shift_id IN ($shift_string)
				AND a.Attendance LIKE '%present%' AND e.a_flag='Yes' ";
		$stmt = $conn->prepare($sql);
		try {
		$stmt->execute([$Date]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    $_SESSION['error']=$e->getMessage();
		}
		

		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	if(isset($_GET['e_date']) && isset($_GET['e_shift']) && isset($_GET['e_sec_id']) && isset($_GET['e_dep_id']) && !isset($_GET['from_date']))
	{

		$Date = $_GET['e_date'];
		$Shift = $_GET['e_shift'];
		$sec_id=$_GET['e_sec_id'];
		$dep_id=$_GET['e_dep_id'];

		$_SESSION['date']=$Date;
		$_SESSION['shift']=$Shift;
		$_SESSION['sec_ids']=$sec_id;
		$_SESSION['dep_ids']=$dep_id;

		$shift_array = explode(",", $Shift);
		$shift_array = array_map('trim', $shift_array);
		$shift_string = "'" . implode("','", $shift_array) . "'";

		$dep_array = explode(",", $dep_id);
		$dep_array = array_map('trim', $dep_array);
		$dep_string = "'" . implode("','", $dep_array) . "'";

		$sec_array = explode(",", $sec_id);
		$sec_array = array_map('trim', $sec_array);
		$sec_string = "'" . implode("','", $sec_array) . "'";

		$sql = "SELECT a.*,e.EmployeeCode,e.employee_name,e.Category,d.department_name,s.Section_name,shift.Shift_name,c.Contractor_name 
				FROM Attendance a 
				LEFT JOIN Employee e ON a.employee_id = e.employee_id 
				LEFT JOIN [Department] d ON e.Department_id = d.department_id 
				LEFT JOIN [Section] s ON s.Section_id=e.Section_id 
				LEFT JOIN Shift shift ON shift.Shift_id=a.Shift_id 
				LEFT JOIN Contractor c ON e.Contractor_id=c.Contractor_id 
				WHERE e.Section_id IN ($sec_string) AND a.a_date=? AND a.Shift_id IN ($shift_string)
				AND a.Attendance NOT LIKE '%present%'
				AND a.a_status IN ('Approved', 'verified')";
		$stmt = $conn->prepare($sql);
		try {
		$stmt->execute([$Date]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    $_SESSION['error']=$e->getMessage();
		}
		

		header('Content-Type: application/json');
		echo json_encode($data);		
	}

	if(!isset($_GET['date']) && !isset($_GET['shift']) && isset($_GET['sec_id']) && isset($_GET['dep_id'])&& !isset($_GET['from_date']) && !isset($_GET['to_date'])){

		$dep_id=$_GET['dep_id'];
		$sec_id=$_GET['sec_id'];

		$_SESSION['EM_dep_ids']=$dep_id;
		$_SESSION['EM_sec_ids']=$sec_id;



		
$sec_array = explode(",", $sec_id);
$sec_array = array_map('trim', $sec_array);

// Check if 'null' is present in the array
$contains_null = in_array('null', $sec_array);

// Remove 'null' value from the array
$sec_array = array_filter($sec_array, function($value) {
    return $value !== 'null';
});

// Prepare the IN clause for non-null values
$in_clause = implode(',', $sec_array);




		$sec_array = explode(",", $in_clause);
		$sec_array = array_map('trim', $sec_array);
		$in_clause = "'" . implode("','", $sec_array) . "'";


// Build the SQL query
$sql = "SELECT e.*, d.department_name, d.department_id, s.Section_name, c.Contractor_name, c.Contractor_id,div.*,l.*
        FROM Employee e
        LEFT JOIN [Department] d ON e.Department_id = d.department_id
        LEFT JOIN [Section] s ON e.Section_id = s.Section_id
        LEFT JOIN Contractor c ON e.Contractor_id = c.Contractor_id
                    LEFT JOIN [Location] l ON e.location_id = l.location_id
                    LEFT JOIN [Division] div ON e.division_id = div.division_id
        ";

// Add the condition for non-null values if present
if (!empty($in_clause)) {
    $sql .= " WHERE e.Section_id IN ($in_clause)";
}

// Add the condition for 'null' value if present
if ($contains_null) {
    if (!empty($in_clause)) {
        $sql .= " OR e.Section_id IS NULL";
    } else {
        $sql .= " WHERE e.Section_id IS NULL";
    }
}
		
		$stmt = $conn->prepare($sql);
		try {
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    $_SESSION['error']=$e->getMessage();
		}
		

		header('Content-Type: application/json');
		echo json_encode($data);		
	}		

	if (isset($_POST['Verify'])) {
		if (isset($_POST['checking'])) {
			$approve=$_POST['checking'];	
			// $id=implode(',', $approve);		
			
				checking_query($approve);				
			
		}
		else{
			$_SESSION['error']="Please check any employee for approve them ";
		}
		if (isset($_POST['remarking'])) {
		    $remarks = $_POST['remarking'];
		    $ids = $_POST['id'];

		    foreach ($remarks as $index => $remark) {
		        if ($remark !== "") {
		            $id = $ids[$index];
		            insert_remark($remark, $id);
		        }
		    }
		}
		header("Location: attendance.php");
	}

	if(isset($_POST['download'])){
		if(isset($_POST['employee_id'])){
		$id=$_POST['employee_id'];
		$name=$_POST['employee_name'];	
		$Contractor=$_POST['Contractor'];
		$category=$_POST['category'];
		$department_name=$_POST['department_name'];
		$Section_name=$_POST['Section_name'];	
		$shift=$_POST['shift_name'];
		$Attendance=$_POST['Attendance'];
		$a_status=$_POST['a_status'];
		$in_time=$_POST['in_time'];
		$out_time=$_POST['out_time'];
    	$remark=$_POST['remarking'];
		$approved_by=$_POST['approved_by'];
		$verified_by=$_POST['verified_by'];

		$data = array();
		for ($i = 0; $i < count($id); $i++) {
		    $data[] = array('Employee ID' => $id[$i], 'Employee Name' => $name[$i], 'Contractor'=>$Contractor[$i], 'Category'=>$category[$i], 'Department' => $department_name[$i], 'Section'=>$Section_name[$i], 'Shift'=>$shift[$i],'Attendance'=>$Attendance[$i], 'Status' => $a_status[$i], 'In time'=>$in_time[$i], 'Out time'=>$out_time[$i], 'Remarks'=>$remark[$i], 'Approved By'=>$approved_by[$i], 'Verified By'=>$verified_by[$i]);
		}	

      $filename = "HR-Attendance-".date('Y-m-d_H-i-s') . ".xls";     
            header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");		
		ExportFile($data);

        exit();
        }
        else{$_SESSION['error']="Zero row ";}
    header("Location: attendance.php");
		
	}

?>