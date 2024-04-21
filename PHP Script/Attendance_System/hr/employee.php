<?php 
	include_once 'session.php';
	include_once 'header.php';  
	include_once 'data.php';

  $departments = display_department();
  $sections=display_section();
  $dep_names = json_encode($sections);

	$employees=display_employee();
  $locs=display_loc();

  $divsa=display_div();
  $depsa=display_dep();
  $secsa=display_sec();
  $cons=display_con(); 

  $divs=json_encode($divsa);
  $deps=json_encode($depsa);
  $secs=json_encode($secsa);



  $emp_count = $employees['total'];
  $active = $employees['active'];  
  $EMs = $employees['sections'];
?>

<body>
	<?php 
		include_once 'sidenav.php';
     	// $users=display();
    ?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      Employee Master
    </div>
<?php 


      if (isset($_SESSION['error'])) {
        print_r(" <div class='alert alert-danger alert-dismissible'>
              ".$_SESSION['error']."<div class='close'>&times;</div>
              </div>
            ");
            unset($_SESSION['error']);
      } 
      if (isset($_SESSION['msg'])) {
        print_r(" <div class='alert alert-success alert-dismissible'>
              ".$_SESSION['msg']."<div class='close'>&times;</div>
              </div>
            ");
            unset($_SESSION['msg']);
      } 


  if (isset($_SESSION['date'])) {
    $date = $_SESSION['date'];

  } else {
    $date = ''; 
  }
  if (isset($_SESSION['shift'])) {
    $shift = $_SESSION['shift'];
  } else {
    $shift = ''; 
  }


if (isset($_SESSION['EM_sec_ids'])) {
  $sec_id = $_SESSION['EM_sec_ids'];
} else {
  $sec_id = ''; 
}
if (isset($_SESSION['EM_dep_ids'])) {
  $dep_id = $_SESSION['EM_dep_ids'];
} else {
  $dep_id = ''; 
}
  // echo($_SESSION['date'] .$_SESSION['shift'] .$_SESSION['sec_ids']);

  echo '<script> 
   var date = "' . $date. '"; 
   var shift = "' . $shift . '"; 
   var sec_id = "' . $sec_id . '";
   var dep_id = "' . $dep_id . '";
   var expire = "' . $_SESSION['expire'] . '";
   var start = "' . $_SESSION['start'] . '";
   var div_names = ' . $divs . ';
   var dep_names = ' . $deps . ';   
   var sec_names = ' . $secs . ';
   var now = "' . time() . '";
  </script>';

?>
      <div class="form-popup" id="CreateForm">
        <h1>Create New Employee</h1>
        <form method="POST" action="create_employee.php" class="form-container">
          <label for="emp_id">Employee ID:</label>
          <input type="number" id="emp_id" name="emp_id" placeholder="Enter Employee ID" required>              

          <label for="emp_f_name">First Name:</label>
          <input type="text" id="emp_f_name" name="emp_f_name" placeholder="First Name" required>                  

          <label for="emp_l_name">Last Name:</label>
          <input type="text" id="emp_l_name" name="emp_l_name" placeholder="Last Name" required>     

          <label for="emp_email">Email:</label>
          <input type="email" id="emp_email" name="emp_email" placeholder="Enter Email">



          <div class="button-container">
          <button type="button" class="btn cancel" onclick="closeUser()">Close</button>
          <input type="submit" class="btn create" name="create" value="Create">
        </div>
        </form>
      </div>

    <div class="ribbon">
      <span class="card">Total employee : <?php echo($emp_count); ?></span>
      <span class="card">Active employee : <?php echo($active); ?></span>
      <span id="rowCount" class="card">Filtered employee :</span>

      <!-- <button onclick="openUser()" class="btn">New</i></button> -->
        <input type="search" id="searchInput" class="custom-input" onkeyup="myFunction()" placeholder="Search..">
        <div class="multipleSelection">
          <div class="selectBox" onclick="showCheckDepartment(event)" >
            <select id="mySelectDepartment">
              <option>Department</option>
            </select>
            <div class="overSelect"></div>
          </div>

          <div id="checkDepartment" class="m_select">
            <label>
              <input type="checkbox" onclick="Select_All_Department(this)">
              Select all
            </label>
            <?php foreach ($depsa as $department): ?>
              <label>
                <input type="checkbox" value="<?php echo($department['department_name']); ?>" onclick="showSectionByDepartment()" id="<?php echo($department['department_id']); ?>" class='department'>
                <?php echo($department['department_name']); ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="multipleSelection">
          <div class="selectBox" onclick="showCheckSection(event)" >
            <select id="mySelectSection">
              <option>Section</option>
            </select>
            <div class="overSelect"></div>
          </div>

          <div id="checkSection" class="m_select">
            <label>
              <input type="checkbox" onclick="Select_All_Section(this)">
              Select all
            </label>
              <label>
                <input type="checkbox" value="Unmaped employees" id="null">
                Unmaped employee
              </label>
            <?php foreach ($sections as $section): ?>
              <label>
                <input type="checkbox" value="<?php echo($section['Section_name']); ?>" id="<?php echo($section['Section_id']); ?>" class='section'>
                <?php echo($section['Section_name']); ?>
              </label>

            <?php endforeach; ?>
          </div>
       </div>
      <button id="exportButton">Download</button>   
    </div>

    <div class="outer-wrapper">
    <div class="table-wrapper">
      <table id="myTable">
<thead>
                <tr>
                  <th>Employee Id</th>
                  <th>Name</th>  
                  <th>Location
                    <select id="location-filter">
                      <option value="">Select All</option>
                    </select>
                  </th>
                  <th>Division 
                  <select id="Division-filter">
                    <option value="">Select All</option>
                  </select>          
                  </th>  
                  <th>Department
                  <select id="Department-filter">
                     <option value="">Select All</option>
                  </select>
                  </th>
                  <th>Section
                  <select id="Section-filter">
                    <option value="">Select All</option>
                  </select>
                 </th>
                  <th>Contractor
                 <select id="contractor-filter">
                     <option value="">Select All</option>
                  </select>
                  </th>
                  <th>Designation
                  <select id="Designation-filter">
                     <option value="">Select All</option>
                  </select>
                  </th>
                  <th>Employee Type
                  <select id="Employee-filter">
                     <option value="">Select All</option>
                  </select>
                  </th>
                  <th>Attendance Flag
                  <select id="attendance-filter">
                    <option value="">Select All</option>
                  </select>  
                  </th> 
                  <th>Status
                  <select id="Isworking-filter">
                     <option value="">Select All</option>
                  </select>
                  </th>             
                  <th>Gender
                  <select id="Gender-filter">
                     <option value="">Select All</option>
                  </select>
                  </th>
                  <th>Father Name</th>       
                  <th>Mother Name</th>                 
                  <th>E-mail</th>
                  <th>Salary</th>
                  <th>Category</th>               
                  <th>DOJ</th>
                  <th>DOR</th>
                  <th>Blood Group</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tableData">
                 <?php foreach ($EMs as $EM): ?>
                  <tr>
                    <td><?php echo($EM['EmployeeCode']); ?></td>
                    <td><?php echo($EM['employee_name']); ?></td>
                    <td><?php echo($EM['location_name']); ?></td>
                    <td><?php echo($EM['division_name']); ?></td>   
                    <td><?php echo($EM['department_name']); ?></td>
                    <td><?php echo($EM['Section_name']); ?></td>
                    <td><?php echo($EM['Contractor_name']); ?></td>
                    <td><?php echo($EM['Designation']); ?></td>
                    <td><?php echo($EM['Employee_type']); ?></td>    
                    <td><?php echo($EM['a_flag']); ?></td>  
                    <td><?php echo($EM['is_working']); ?></td>                                     
                    <td><?php echo($EM['Gender']); ?></td>
                    <td><?php echo($EM['Father_name']); ?></td>
                    <td><?php echo($EM['Mother_name']); ?></td>
                    <td><?php echo($EM['email']); ?></td>
                    <td><?php echo($EM['salary']); ?></td>      
                    <td><?php echo($EM['Category']); ?></td>
                    <td><?php echo($EM['DOJ']); ?></td>
                    <td><?php echo($EM['DOR']); ?></td>
                    <td><?php echo($EM['Blood_group']); ?></td>  
                    <td><?php echo($EM['Address']); ?></td>  
                    <td>
                     <a href="#"><button onclick="openEdit('<?php echo($EM['EmployeeCode']); ?>', '<?php echo($EM['employee_name']); ?>', '<?php echo($EM['Contractor_id']); ?>', '<?php echo($EM['department_id']); ?>', '<?php echo($EM['Section_id']); ?>', '<?php echo($EM['a_flag']); ?>', '<?php echo($EM['location_id']); ?>', '<?php echo($EM['division_id']); ?>')" class="btn edit">Edit</button></a>

                      <a href="#"><button onclick="openDelete('<?php echo($EM['EmployeeCode']); ?>', '<?php echo($EM['employee_name']); ?>')" class="btn delete">Delete</button></a>
                    </td>        
                  </tr>
                <?php endforeach; ?> 
        
              </tbody>
            </table>
        </div>
    </div>

      <div class="form-popup" id="EditForm">
       <h1 ><span id="emp_name"></span></h1> 
          <form method="POST" action="edit_employee.php" class="form-container">

                  <input type="number" name="e_employee_id" hidden>

                  <input type="number" name="before_e_location_id" hidden>
                  <input type="hidden" name="before_e_division_id" hidden>
                  <input type="number" name="before_e_department_id" hidden>
                  <input type="hidden" name="before_e_section_id" hidden>
                  <input type="hidden" name="before_e_contractor_id" hidden>
                  <input type="hidden" name="before_a_flag" hidden>

                  <label for="location_name">Location :</label>  
                  <select name="location_name" onchange="fetchSelectDivision(this.value)">
                    <option value="-1">None</option>
                    <?php  foreach($locs as $loc): ?>
                      <option value="<?php echo($loc['location_id']); ?>"><?php echo($loc['location_name']); ?></option>

                    <?php endforeach; ?>
                  </select> 

                  <label for="division_name">Division :</label>              
                  <select name="division_name" id="division_name" onchange="fetchSelectDepartment(this.value)">
                   <option value="-1">None</option>
            
                  </select>                     
                  <label for="department_name">Department :</label>              
                  <select name="department_name" id="department_name" onchange="fetchSelectSection(this.value)">

                  </select> 
                  <label for="section_name">Section :</label>              
                  <select name="section_name" id="section_name">

                  </select>
                  <label for="contractor_name">Contractor :</label>              
                  <select name="contractor_name">
                    <?php  foreach($cons as $con): ?>
                      <option value="<?php echo($con['Contractor_id']); ?>"><?php echo($con['Contractor_name']); ?></option>

                    <?php endforeach; ?>
                  </select> 
                  <label for="a_flag">Attendance Flag :</label>              
                  <select name="a_flag">

                      <option value=Yes>Yes</option>
                      <option value=No>No</option>

                  </select> 

                  <div class="button-container">     
                    <button type="button" onclick="closeEdit()" class="btn cancel">Cancel</button>
                    <input type="submit" name="edit" value="Save" class="btn create">
                  </div>
        </form>

      </div>
      <div class="form-popup" id="DeleteForm">
       <h1 ><span id="d_emp_name"></span></h1> 
          <form method="POST" action="delete_employee.php" class="form-container">

                  <input type="number" name="d_employee_id" hidden>
                    <span>Are you sure you want to delete the employee</span>


                  <div class="button-container">     
                    <button type="button" onclick="closeDelete()" class="btn create">Cancel</button>
                    <input type="submit" name="edit" value="Delete" class="btn cancel">
                  </div>
        </form>

      </div>

      <div class="form-popup" id="PasswordEditForm">
       
        <h1>Change Password</h1>
          <form method="POST" action="edit_profile.php" class="form-container">
        
            
              <input type="hidden" name="file" value="employee.php" hidden>
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" placeholder="Enter the Current Password" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" placeholder="Enter the New Password" required>
            <label for="confirm_new_password">Confirm New Password:</label>
            <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Enter the Confirm New Password" required>

            <div class="button-container">
              <button type="button" onclick="PasswordcloseEdit()" class="btn cancel">Cancel</button>
              <input type="submit" name="edit" value="Update password" class="btn create">
            </div>
          </form>

      </div>

  </section>

<script src="./../js/nav_bar.js"></script>
<script src="./../js/error.js"></script>
<script src="./../js/session_expire.js"></script>
<script type="text/javascript">

  var showSection = true;
  var showDepartment = true;

  document.getElementById("PasswordEditForm").style.display = "none";

  function PasswordopenEdit() {
    document.getElementById("PasswordEditForm").style.display = "block";
  }


  function PasswordcloseEdit() {
    document.getElementById("PasswordEditForm").style.display = "none";
  }

	document.getElementById("CreateForm").style.display = "none";


	function openUser() {
	  document.getElementById("CreateForm").style.display = "block";
	}

	function closeUser() {
	  document.getElementById("CreateForm").style.display = "none";
	}

	document.getElementById("EditForm").style.display = "none";
	function openEdit(id,employee_name,con_id,dep_id,sec_id,flag,loc_id,div_id) {
    document.getElementById("emp_name").innerHTML = 'Edit Employee : '+employee_name;
    document.getElementsByName("e_employee_id")[0].value =id;
    // document.getElementsByName("before_e_f_employee_name")[0].value =f_name;
    // document.getElementsByName("before_e_f_employee_name")[0].value =l_name;
    // document.getElementsByName("before_e_leader_id")[0].value = leader_id; 
    document.getElementsByName("before_e_location_id")[0].value = loc_id;  
    document.getElementsByName("before_e_division_id")[0].value =div_id;
    document.getElementsByName("before_e_department_id")[0].value = dep_id;  
    document.getElementsByName("before_e_section_id")[0].value =sec_id;
    document.getElementsByName("before_e_contractor_id")[0].value =con_id;
    document.getElementsByName("before_a_flag")[0].value =flag;    

if (loc_id=='') {
   fetchSelectDivision('-1');
}else{
   fetchSelectDivision(loc_id);
}
if
 (div_id=='') {
    fetchSelectDepartment('-1'); 
}else{
    fetchSelectDepartment(div_id);   
}
if (dep_id=='') {

    fetchSelectSection('-1');
}else{
    fetchSelectSection(dep_id);  
}
 


    // document.getElementsByName("e_f_employee_name")[0].value = f_name;
    // document.getElementsByName("e_l_employee_name")[0].value = l_name;
    // document.getElementsByName("e_employee_email")[0].value = email;
    // document.querySelector("select[name='leader_name']").value = leader_id;
    document.querySelector("select[name='location_name']").value = loc_id;
    document.querySelector("select[name='division_name']").value = div_id;    
    document.querySelector("select[name='department_name']").value = dep_id;
    document.querySelector("select[name='section_name']").value = sec_id;
    document.querySelector("select[name='contractor_name']").value = con_id;
    document.querySelector("select[name='a_flag']").value = flag;    
    // document.getElementsByName("manager_name")[0].value = manager_id;

    document.getElementById("EditForm").style.display = "block";



	}

	function closeEdit() {
	  document.getElementById("EditForm").style.display = "none";
	}

  document.getElementById("DeleteForm").style.display = "none";
  function openDelete(id,employee_name) {
    document.getElementById("d_emp_name").innerHTML = 'Delete Employee : '+employee_name;
    document.getElementsByName("d_employee_id")[0].value =id;

    // document.getElementById("d_msg_emp_name").innerHTML = employee_name;


    document.getElementById("DeleteForm").style.display = "block";



  }

  function closeDelete() {
    document.getElementById("DeleteForm").style.display = "none";
  }





document.getElementById('exportButton').addEventListener('click', function () {
  const table = document.getElementById('myTable');
  const rows = table.querySelectorAll('tr');
  let xlsContent = '';


rows.forEach(function (row) {
      if (row.style.display !== 'none') { // Check if the row is visible (filtered)


  const cols = Array.from(row.cells).slice(0, -1); // Exclude last column
  const rowData = cols.map(col => {
    const select = col.querySelector('select');
    if (select) {
      // Check if a select element is present in the cell
      const selectedOptions = Array.from(select.selectedOptions);
      const cellText = col.textContent.trim();
      const selectedText = selectedOptions.map(option => option.textContent).join(', ');
      return `${cellText.replace(select.textContent.trim(), '').trim()} (${selectedText})`;
    } else {
      return col.textContent;
    }
  }).join('\t'); // Use tab as separator
  xlsContent += rowData + '\n';

}
});

  const blob = new Blob([xlsContent], { type: 'application/vnd.ms-excel' });
  const today = new Date();
  const formattedDate = today.toISOString().slice(0, 10).replace(/-/g, ''); // Format date
  const fileName = `EmployeeMaster${formattedDate}.xls`; // Create file name with formatted date
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = fileName; // Use the new file name
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
});






function fetchSelectDivision(loc_id) {
  var sectionSelect = document.getElementById('division_name');
  sectionSelect.innerHTML = '';
        var option = document.createElement('option');
        option.value = '0';
        option.textContent = 'None';
      sectionSelect.appendChild(option);        
  div_names.forEach(item => {
    if (loc_id.includes(item.location_id.toString()) ) {
       // || item.location_id == '0'
      var option = document.createElement('option');
      option.value = item.division_id;
      option.textContent = item.division_name;

      sectionSelect.appendChild(option);
    }
  });
}


  function fetchSelectDepartment(div_id) {
      var sectionSelect = document.getElementById('department_name');
      sectionSelect.innerHTML = '';
        var option = document.createElement('option');
        option.value = '0';
        option.textContent = 'None';
      sectionSelect.appendChild(option);   

    dep_names.forEach(item => {

      if (div_id.includes(item.division_id.toString())) {
        var option = document.createElement('option');
        option.value = item.department_id;
        option.textContent = item.department_name;

        sectionSelect.appendChild(option);
      }

    });
  }
  function fetchSelectSection(dep_id) {
      var sectionSelect = document.getElementById('section_name');
      sectionSelect.innerHTML = '';
        var option = document.createElement('option');
        option.value = '0';
        option.textContent = 'None';
      sectionSelect.appendChild(option);   
    sec_names.forEach(item => {

      if (dep_id.includes(item.department_id.toString())) {
        var option = document.createElement('option');
        option.value = item.Section_id;
        option.textContent = item.Section_name;

        sectionSelect.appendChild(option);
      }

    });
  }


function myFunction() {
  var input, filter, table, tr, td_id, td_name, i, id_Value, name_Value;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableData");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td_id = tr[i].getElementsByTagName("td")[0];
    td_name = tr[i].getElementsByTagName("td")[1];
    if (td_id && td_name) {
      id_Value = td_id.textContent || td_id.innerText;
      name_Value = td_name.textContent || td_name.innerText;      
      if (id_Value.toUpperCase().indexOf(filter) > -1 || name_Value.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
  tableRow();
}


function tableRow() {
    const rowCountSpan = document.getElementById("rowCount");
    const tableData = document.getElementById("tableData").children;

    function updateRowCount() {
        const visibleRowCount = Array.from(tableData).filter(row => row.style.display !== "none").length;
        rowCountSpan.textContent = `Filtered employee : ${visibleRowCount}`;
    }

    updateRowCount();
}

// Call the function whenever you need to update the row count
tableRow();



const table = document.getElementById("myTable");
  const filters = [,,document.getElementById("location-filter"),document.getElementById("Division-filter"),document.getElementById("Department-filter"),document.getElementById("Section-filter"),document.getElementById("contractor-filter"),document.getElementById("Designation-filter"),document.getElementById("Employee-filter"),document.getElementById("attendance-filter"),document.getElementById("Isworking-filter"),document.getElementById("Gender-filter"),,,,,,,,,,];

  function populateFilterOptions(selectElement, columnIndex) {
    const uniqueValues = new Set();
    for (let i = 1; i < table.rows.length; i++) {
      uniqueValues.add(table.rows[i].cells[columnIndex].textContent);
    }
    selectElement.innerHTML = `<option value="selectAll">Select All</option>${Array.from(uniqueValues).map(value => `<option value="${value}">${value}</option>`).join('')}`;
  }

  filters.forEach((filter, index) => {
    populateFilterOptions(filter, index);
    filter.addEventListener("change", applyFilters);
  });

  function applyFilters() {
    const filterValues = filters.map(filter => filter.value);
    table.querySelectorAll("tbody tr").forEach(row => {
      const cellValues = Array.from(row.cells).map(cell => cell.textContent);
      row.style.display = filterValues.every((value, index) => value === "selectAll" || cellValues[index] === value) ? "" : "none";
    });
      tableRow();
  }
  const nameFilter = document.getElementById("Isworking-filter");
  const desiredValue = "Working";

  for (let i = 0; i < nameFilter.options.length; i++) {
    if (nameFilter.options[i].value === desiredValue) {
      nameFilter.selectedIndex = i;
      break; // Optional: Exit the loop if the value is found
    }else{
      nameFilter.selectedIndex = 1; // For the "Select All" option
    }
  }


applyFilters(); 


  if (dep_id !== undefined && dep_id !== null && dep_id !== '') {
    

    // Split the shift string into an array of values
    var depValues = dep_id.split(',');

    // Check the checkboxes corresponding to the shift values
    depValues.forEach(function(value) {
      var checkbox = document.querySelector('.department[id="' + value + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });
    display_Department();

  }else{


  <?php foreach ($departments as $department): ?>
    var checkbox= document.querySelector('.department[id="' + '<?php echo($department['department_id']); ?>' + '"]');
    checkbox.checked = true;

  <?php endforeach; ?>
  display_Department();

  }
  if (sec_id !== undefined && sec_id !== null && sec_id !== '') {
    

    // Split the shift string into an array of values
    var secValues = sec_id.split(',');

    // Check the checkboxes corresponding to the shift values
    secValues.forEach(function(value) {
      var checkbox = document.querySelector('.section[id="' + value + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });
    display_Section();

  }else{
    
    var checkbox= document.querySelector('.section[id="' + 'null' + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
  <?php foreach ($sections as $section): ?>
    var checkbox= document.querySelector('.section[id="' + '<?php echo($section['Section_id']); ?>' + '"]');
    checkbox.checked = true;

  <?php endforeach; ?>
  display_Section();
  }


function showSectionByDepartment(){


var dep_id = getSelectedDepartment();
// console.log(dep_id);
  sec_names.forEach(item => {
// console.log(sec_names);    
    if (dep_id.includes(item.department_id)) {
      var checkbox = document.getElementById(item.Section_id);
      if (checkbox) {
        checkbox.checked = true;
      }
    }
  });
 

}
    function showCheckDepartment() {
      var checkboxes = document.getElementById("checkDepartment");

      if (showDepartment) {
        checkboxes.style.display = "block";
        showDepartment= false;
      } else {
        checkboxes.style.display = "none";
        showSectionByDepartment();
        display_Department();
        display_Section();
        showDepartment = true;
        fetchTableData(getSelectedSection(),getSelectedDepartment());
        event.stopPropagation();
      }
    }

    function showCheckSection() {
      var checkboxes = document.getElementById("checkSection");

      if (showSection) {
        checkboxes.style.display = "block";
        showSection= false;
      } else {
        
        checkboxes.style.display = "none";
        display_Section();
        showSection=true;
        fetchTableData(getSelectedSection(),getSelectedDepartment());
        event.stopPropagation();
      }
    }


    document.addEventListener('click', function(event) {
        if (!event.target.closest(".selectBox") && !event.target.matches('input[type="checkbox"]')) {

          var Departmentdropdown = document.getElementById("checkDepartment");
          var Sectiondropdown = document.getElementById("checkSection");

          if (showDepartment==false && !event.target.closest("#checkDepartment")) {
            Departmentdropdown.style.display = "none";
            showDepartment = true;  
            display_Department();
          }
          if(showSection==false && !event.target.closest("#checkSection")){
            Sectiondropdown.style.display = "none";
            showSection = true;  
            display_Section();
          }


          if ((Departmentdropdown.style.display == "none" && Sectiondropdown.style.display == "none") && !(showDepartment==false || showSection==false)) {
            fetchTableData(getSelectedSection(),getSelectedDepartment());
          }
        }

    });

  function fetchTableData(sec_id,dep_id) {
    
    fetch(`data.php?&sec_id=${sec_id}&dep_id=${dep_id}`)
      .then(response => response.json())
      .then(data => {


        const tableDataElement = document.getElementById('tableData');
        tableDataElement.innerHTML = '';




        data.forEach(row => {
          Object.keys(row).forEach((key) => {
            // Check if the value is null or undefined and assign an empty string if true
            if (row[key] == null || row[key] == undefined) {
              row[key] = '';
            }
          });

          const tableRow = document.createElement('tr');
          tableRow.innerHTML = `
            <td>${row.EmployeeCode}</td>
            <td>${row.employee_name}</td>
            <td>${row.location_name}</td>
            <td>${row.division_name}</td>
            <td>${row.department_name}</td>
            <td>${row.Section_name}</td>
            <td>${row.Contractor_name}</td>  
            <td>${row.Designation}</td>             
            <td>${row.Employee_type}</td>
            <td>${row.a_flag}</td>
            <td>${row.is_working}</td>
            <td>${row.Gender}</td>
            <td>${row.Father_name}</td>
            <td>${row.Mother_name}</td>
            <td>${row.email}</td>
            <td>${row.salary}</td>
            <td>${row.Category}</td>
            <td>${row.DOJ}</td>
            <td>${row.DOR}</td>
            <td>${row.Blood_group}</td>
            <td>${row.Address}</td>

            <td>
                <a>
                    <button onclick="openEdit('${row.EmployeeCode}', '${row.employee_name}', '${row.Contractor_id}', '${row.department_id}', '${row.Section_id}', '${row.a_flag}', '${row.location_id}', '${row.division_id}')" class="btn edit">Edit</button>
               </a>
                <a href="delete_employee.php?emp_id=${row.EmployeeCode}">
                    <button class="btn delete">Delete</button>
                </a>
            </td>
          `;
          tableDataElement.appendChild(tableRow);
      
        });

  const nameFilter = document.getElementById("Isworking-filter");
  const desiredValue = "Working";

  for (let i = 0; i < nameFilter.options.length; i++) {
    if (nameFilter.options[i].value === desiredValue) {
      nameFilter.selectedIndex = i;
      break; // Optional: Exit the loop if the value is found
    }else{
      nameFilter.selectedIndex = 1; // For the "Select All" option
    }
  }

      applyFilters(); 
        tableRow ();
      })
      .catch(error => console.error(error));
  }


function getSelectedSection(){
  var s = [];

  var checkboxes = document.querySelectorAll("#checkSection input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      if (checkboxes[i].id === "selectAll") {
        // s = checkboxes[i].id;
        // break; // Exit the loop if "Select all" is selected
      } else {
        s.push(checkboxes[i].id);
      }
    }
  }
  
  return s.join(",");
}

function getSelectedDepartment() {
  var s = [];

  var checkboxes = document.querySelectorAll("#checkDepartment input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      if (checkboxes[i].id === "selectAll") {
        // s = checkboxes[i].id;
        // break; // Exit the loop if "Select all" is selected
      } else {
        s.push(checkboxes[i].id);
      }
    }
  }
  
  return s.join(",");
}

function Select_All_Section(checkbox) {
  var checkboxes = document.querySelectorAll("#checkSection input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = checkbox.checked;
  }

  // var selectAllCheckbox = document.getElementById("selectAll");
  // selectAllCheckbox.checked = checkbox.checked;


}
// var sec = [];
function display_Section() {
  var s = [];

  var checkboxes = document.querySelectorAll("#checkSection input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      if (checkboxes[i].parentNode.innerText.trim() != "Select all") {
        s.push(checkboxes[i].value);
      }
    }
  }

  var selectBox = document.getElementById("mySelectSection");
  selectBox.options[0].text = s.join(", ") || "Section";
}


function Select_All_Department(checkbox) {

  var checkboxes = document.querySelectorAll("#checkDepartment input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = checkbox.checked;
  }

  // var selectAllCheckbox = document.getElementById("selectAll");
  // selectAllCheckbox.checked = checkbox.checked;
  showSectionByDepartment();

}

function display_Department() {
  var s = [];

  var checkboxes = document.querySelectorAll("#checkDepartment input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      if (checkboxes[i].parentNode.innerText.trim() != "Select all") {
        s.push(checkboxes[i].value);
      }
    }
  }

  var selectBox = document.getElementById("mySelectDepartment");
  selectBox.options[0].text = s.join(", ") || "Department";

}


</script>
</body>
</html>


