<?php 
	include_once "./../config.php";
	include_once 'session.php';
	
	function employee_id($sec_ids, $from_date, $to_date) {
	    global $conn;

	    $sec_ids_array = explode(',', $sec_ids); // Split the string of section IDs into an array

	    $placeholders = implode(',', array_fill(0, count($sec_ids_array), '?')); // Create a comma-separated list of placeholders for the SQL query

	    $fetch_query = "SELECT e.EmployeeCode,e.employee_id, e.employee_name, d.department_name, s.Section_name
					FROM Employee e
					LEFT JOIN [Department] d ON e.Department_id = d.department_id
					LEFT JOIN [Section] s ON e.Section_id = s.Section_id
					WHERE e.Section_id IN ($placeholders)
					  AND e.is_working = 'Working'
					  AND EXISTS (
					      SELECT 1
					      FROM Attendance a
					      WHERE e.employee_id = a.employee_id
					        AND a.a_status = 'verified'
					        AND a.a_date BETWEEN ? AND ?
					  )";

	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare($fetch_query);
	    
	    // Pass the array of section IDs and date parameters as a parameter
	    $params = array_merge($sec_ids_array, [$from_date, $to_date]);
	    
	    $sql->execute($params);
	    
	    $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $emp_id = $sql->fetchAll();

	    return $emp_id;
	}

	function ExportFile($records) {
	  $heading = false;
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
	    if(!empty($records))

		  echo "\nFrom date :$from_date \t\t To date : $to_date\n\n";
	    	
	      foreach($records as $row) {
	      if(!$heading) {
	        echo implode("\t", array_keys($row)) . "\n";
	        $heading = true;
	      }
	      echo implode("\t", array_values($row)) . "\n";
	      }

	    exit;
	}

	if (isset($_GET['from_date']) AND isset($_GET['to_date'])) {

	$from_date = $_GET['from_date'];
	$to_date = $_GET['to_date'];
	// $Shift = $_GET['shift'];
	$dep_id=$_GET['dep_id'];
	$sec_id=$_GET['sec_id'];

	$_SESSION['from_date']=$from_date;
	$_SESSION['to_date']=$to_date;
	$_SESSION['sec_ids']=$sec_id;
	$_SESSION['dep_ids']=$dep_id;
	$result = array();
	foreach (employee_id($sec_id, $from_date, $to_date) as $value) {
	    $emp_id=$value['employee_id'];

	    $sql = "SELECT a.employee_id,a.Status_code,a.a_date,a.Shift_id,shift.Shift_name 
			    FROM Attendance a 
			    INNER JOIN Shift shift ON shift.Shift_id=a.Shift_id 
			    WHERE a.employee_id=? AND a.a_status=? AND a.a_date BETWEEN ? AND ?";
	    $stmt = $conn->prepare($sql);
	    $stmt->execute([$emp_id,'verified',$from_date,$to_date]);
	    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    if (count($data)>0) { 			// print_r($data);
	    

	    foreach ($data as $row) { 
	        $employee_id = $value['EmployeeCode'];
	        $employee_name = $value['employee_name'];
			$department_name=$value['department_name'];
			$Section_name=$value['Section_name'];
	        // check if the employee id already exists in the result array()y
	        if (!isset($result[$employee_id])) {
	            // if not, add the employee id to the result array
	            $result[$employee_id] = array(

	                'employee_id' => $employee_id,
	                 'employee_name' => $employee_name,  
	                'department_name' => $department_name,
	                 'section_name' => $Section_name,  


	            );

	        }

	        // add the attendance data to the result array
		    if (isset($result[$employee_id][$row['a_date']])) {
		        $result[$employee_id][$row['a_date']] .= '&' . $row['Status_code'].' - '.$row['Shift_name'];
		    }
		    else {
		        $result[$employee_id][$row['a_date']] = $row['Status_code'].' - '.$row['Shift_name'];
		    }

	    }


	    $result = array_values($result);
	    }

	}
	    header('Content-Type: application/json');
	    echo json_encode($result);
	}

	if(isset($_POST['range_download'])){
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$department_name = $_POST['department_name'];
			$Section_name = $_POST['section_name'];

			$excludedKeys = ['from_date', 'to_date', 'range_download', 'id', 'name', 'department_name', 'section_name'];
			$keys = array_diff(array_keys($_POST), $excludedKeys);


			$data = array();
			for ($i = 0; $i < count($id); $i++) {
			    $employeeData = array(
			        'Employee ID' => $id[$i],
			        'Employee Name' => $name[$i],
			        'Department' => $department_name[$i],
			        'Section' => $Section_name[$i]
			    );

			    foreach ($keys as $key) {
			        $employeeData[$key] = $_POST[$key][$i];
			    }

			    $data[] = $employeeData;
			}

			
      $filename = "Department-Attendance-".date('Y-m-d_H-i-s') . ".xls";     
            header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=\"$filename\"");		
		ExportFile($data);

        exit();
        }
        else{$_SESSION['error']="Zero row ";}
    header("Location: download.php");
		
	}


 ?>

