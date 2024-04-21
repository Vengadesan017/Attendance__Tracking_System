<?php 
  include_once 'session.php';
  include_once 'header.php';
  include_once 'data.php'; 
  $departments = display_department($_SESSION['user_id']);
  $sections=display_section($_SESSION['user_id']);
  $EM_array = display_employee();
  $dep_names = json_encode($sections);

  $emp_count = $EM_array['total'];
  $active = $EM_array['active'];  
  $EMs = $EM_array['sections'];
?>

<body>
<?php include_once 'sidenav.php'; ?>
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

  // echo($_SESSION['date'].'jhfhjf' .$_SESSION['shift'].'ytftf' .$_SESSION['sec_ids']);
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
   var dep_names = ' . $dep_names . ';
   var now = "' . time() . '";
  </script>';

?>
<div>
    <div class="ribbon">

      <span class="card">Total employee : <?php echo($emp_count); ?></span>
      <span class="card">Active employee : <?php echo($active); ?></span>
      <span id="rowCount" class="card">Filtered employee :</span>
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
            <?php foreach ($departments as $department): ?>
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
                  </tr>
                <?php endforeach; ?> 
              </tbody>
            </table>
        </div>
    </div>



      <div class="form-popup" id="PasswordEditForm">
       
        <h1>Change Password</h1>
          <form method="POST" action="edit_profile.php" class="form-container">
        
            
              <input type="hidden" name="file" value="dashboard.php" hidden>
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

  <?php foreach ($sections as $section): ?>
    var checkbox= document.querySelector('.section[id="' + '<?php echo($section['Section_id']); ?>' + '"]');
    checkbox.checked = true;

  <?php endforeach; ?>
  display_Section();
  }




    document.getElementById('exportButton').addEventListener('click', function () {
      const table = document.getElementById('myTable');
      const rows = table.querySelectorAll('tr');
      let xlsContent = '';

      rows.forEach(function (row) {
    if (row.style.display !== 'none') { // Check if the row is visible (filtered)
        const cols = Array.from(row.cells); // Include all columns
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







function showSectionByDepartment(){


var dep_id = getSelectedDepartment();

  dep_names.forEach(item => {
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
        fetchTableData(getSelectedSection(),getSelectedDepartment());
        showSection = true;
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
        tableRow();


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