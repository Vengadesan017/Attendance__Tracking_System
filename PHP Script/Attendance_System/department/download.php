<?php 
  include_once 'session.php';
  include_once 'header.php';
  include_once 'data.php'; 
  $departments=display_department($_SESSION['user_id']);
  $sections=display_section($_SESSION['user_id']);
  $dep_names = json_encode($sections);
?>

<body>
<?php include_once 'sidenav.php'; ?>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      Download
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


  if (isset($_SESSION['from_date'])) {
    $from_date = $_SESSION['from_date'];

  } else {
    $from_date = ''; 
  }
  if (isset($_SESSION['to_date'])) {
    $to_date = $_SESSION['to_date'];
  } else {
    $to_date = ''; 
  }

  if (isset($_SESSION['sec_ids'])) {
    $sec_id = $_SESSION['sec_ids'];
  } else {
    $sec_id = ''; 
  }
  if (isset($_SESSION['dep_ids'])) {
    $dep_id = $_SESSION['dep_ids'];
  } else {
    $dep_id = ''; 
  }
  // echo($_SESSION['date'] .$_SESSION['shift'] .$_SESSION['sec_ids']);

  echo '<script> 
   var from_date = "' . $from_date. '"; 
   var to_date = "' . $to_date . '"; 
   var dep_id = "' . $dep_id . '";
   var sec_id = "' . $sec_id . '";
   var expire = "' . $_SESSION['expire'] . '";
   var start = "' . $_SESSION['start'] . '";
   var now = "' . time() . '";
   var dep_names = ' . $dep_names . ';
  </script>';

?>

  <div>
    <form method="post" action="<?php echo htmlspecialchars('dep_data.php')?>">
    <div class="ribbon">
    <span id="rowCount" class="card" ></span>
    <input type="date" id="from_datePicker" name="from_date" class="date">
    <input type="date" id="to_datePicker" name="to_date" class="date">

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
  
   
   
    

  
    <div class="outer-wrapper">
    <div class="table-wrapper">
      <table id="myTable">
              <thead>

              </thead>
              <tbody id="tableData">

              
                
        
              </tbody>
            </table>
    </div>
    </div>
    

    </form>
  </div>
      <div class="form-popup" id="EditForm">
       
        <h1>Change Password</h1>
          <form method="POST" action="edit_profile.php" class="form-container">
        
            <input type="hidden" name="file" value="download.php" hidden>
            
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" placeholder="Enter the Current Password" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" placeholder="Enter the New Password" required>
            <label for="confirm_new_password">Confirm New Password:</label>
            <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Enter the Confirm New Password" required>

            <div class="button-container">
              <button type="button" onclick="closeEdit()" class="btn cancel">Cancel</button>
              <input type="submit" name="edit" value="Update password" class="btn create">
            </div>
          </form>

      </div>

  </section>

<script src="./../js/nav_bar.js"></script>
<script src="./../js/error.js"></script>
<script src="./../js/session_expire.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script>
var showSection = true;
var showDepartment = true;
    document.getElementById("EditForm").style.display = "none";

  function openEdit() {
    document.getElementById("EditForm").style.display = "block";
  }


  function closeEdit() {
    document.getElementById("EditForm").style.display = "none";
  }


  if (from_date !== undefined && from_date !== null && from_date !== '') {

    // Set the value of the input field
    document.getElementById("from_datePicker").value = from_date;
  }
  else{
  let today = new Date();
  let day = today.getDate();
  let month = today.getMonth() + 1;
  let year = today.getFullYear();
  let f_day='01';
  // Format date as yyyy-mm-dd
  if (day < 10) {
    day = '0' + day;
    
  }
  if (month < 10) {
    month = '0' + month;
  }


  let formatted_from_Date = year + '-' + month + '-' + f_day;
  // Set date input field value to current date
  document.getElementById('from_datePicker').value = formatted_from_Date;
  }

  if (to_date !== undefined && to_date !== null && to_date !== '') {

    // Set the value of the input field
    document.getElementById("to_datePicker").value = to_date;
  }
  else{
  let today = new Date();
  let day = today.getDate();
  let month = today.getMonth() + 1;
  let year = today.getFullYear();
  let f_day='01';
  // Format date as yyyy-mm-dd
  if (day < 10) {
    day = '0' + day;
    
  }
  if (month < 10) {
    month = '0' + month;
  }

  let formatted_to_Date = year + '-' + month + '-' + day;
 
  // Set date input field value to current date
  document.getElementById('to_datePicker').value = formatted_to_Date;
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




document.getElementById('exportButton').addEventListener('click', function(event) {
    event.preventDefault();
    const table = document.getElementById('myTable');
    const rows = table.querySelectorAll('tbody tr');
    const headerCells = table.querySelectorAll('thead th');
    

    var fromDate = document.getElementById('from_datePicker').value;
    var toDate = document.getElementById('to_datePicker').value;
    var department = document.getElementById('mySelectDepartment').value;
    var section = document.getElementById('mySelectSection').value;

    let xlsContent = `From Date: ${fromDate}\tTo Date: ${toDate}\tDepartment: ${department}\tSection: ${section}\n\n`;


    const headerRowData = Array.from(headerCells).map(cell => cell.textContent).join('\t');
    xlsContent += headerRowData + '\n';

    rows.forEach(function (row) {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(col => {
            const input = col.querySelector('input');
            if (input) {
                if (input.type === 'checkbox') {
                    return input.checked ? 'Checked' : 'Unchecked';
                } else {
                    return input.value;
                }
            } else {
                return col.textContent.trim();
            }
        }).join('\t');

        xlsContent += rowData + '\n';
    });

    const blob = new Blob([xlsContent], { type: 'application/vnd.ms-excel' });
    const today = new Date();
    const formattedDate = today.toISOString().slice(0, 10).replace(/-/g, ''); // Format date
    const fileName = `RangeAttendanceLogs${formattedDate}.xls`; // Create file name with formatted date
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = fileName; // Use the new file name
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});



  function showSectionByDepartment(){

    var dep_id = getSelectedDepartment();
    if (dep_id) {

      dep_names.forEach(item => {
        if (dep_id.includes(item.department_id)) {
          var checkbox = document.getElementById(item.Section_id);
          if (checkbox) {
            checkbox.checked = true;
          }
        }
      });
    }
  }

    // Get the select element
// var selectElement = document.getElementById('mySelect');

// Get the current time
// var currentTime = new Date();

// // Get the current hour
// var currentHour = currentTime.getHours();

// // Set the default selected option based on the current time
// if (currentHour >= 8 && currentHour < 17) {
//   selectElement.value = 'G';
// } else if (currentHour >= 17 && currentHour < 20) {
//   selectElement.value = 'A';
// } else if (currentHour >= 20 || currentHour < 5) {
//   selectElement.value = 'B';
// } else {
//   selectElement.value = 'C';
// }




// get table data from server on page load
    fetchTableData(getFromDate(), getToDate(),getSelectedSection(),getSelectedDepartment());

    //fetch table data from server based on selected date
    document.getElementById('from_datePicker').addEventListener('change', function() {
      fetchTableData(getFromDate(), getToDate(),getSelectedSection(),getSelectedDepartment());
    });

    document.getElementById('to_datePicker').addEventListener('change', function() {
      fetchTableData(getFromDate(), getToDate(),getSelectedSection(),getSelectedDepartment());
    });

    function showCheckSection() {
      var checkboxes = document.getElementById("checkSection");

      if (showSection) {
        checkboxes.style.display = "block";
        showSection= false;
      } else {
        display_Section();
        checkboxes.style.display = "none";       
        showSection = true;
        fetchTableData(getFromDate(), getToDate(),getSelectedSection(),getSelectedDepartment());
        event.stopPropagation();
      }
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
        fetchTableData(getFromDate(), getToDate(),getSelectedSection(),getSelectedDepartment());
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
        fetchTableData(getFromDate(), getToDate(),getSelectedSection(),getSelectedDepartment());
          }
        }

    });

function fetchTableData(from_date, to_date,sec_id,dep_id) {

/////////////////       table   head //////////
  const tableHead = document.querySelector('thead');
  tableHead.innerHTML = '';
  // Remove current table header
  while (tableHead.firstChild) {
    tableHead.removeChild(tableHead.firstChild);
  }

  // Loop through each day in the date range and create a new table header cell for each day
  let currentDate = new Date(from_date);
  const id_th = document.createElement('th');
  const name_th = document.createElement('th');
  const dep_name = document.createElement('th');
  const sec_name= document.createElement('th');
  id_th.textContent = 'Employee ID';
  name_th.textContent = 'Employee Name';
  dep_name.textContent = 'Department Name';
  sec_name.textContent = 'Section Name';
  tableHead.appendChild(id_th);
  tableHead.appendChild(name_th);
  tableHead.appendChild(dep_name);
  tableHead.appendChild(sec_name);
  const monthNames = [
    "jan", "feb", "mar", "apr", "may", "jun",
    "jul", "aug", "sep", "oct", "nov", "dec"
  ];

  while (currentDate <= new Date(to_date)) {
    const th = document.createElement('th');
    const month = monthNames[currentDate.getMonth()];
    const day = currentDate.getDate();

    th.textContent = `${day} ${month}`;
    tableHead.appendChild(th);
    currentDate.setDate(currentDate.getDate() + 1);
  }

  /////////////          table   body /////////
    fetch(`dep_data.php?from_date=${from_date}&to_date=${to_date}&sec_id=${sec_id}&dep_id=${dep_id}`)
      .then(response => response.json())
      .then(data => {
        // clear previous table data
        const tableDataElement = document.getElementById('tableData');
        tableDataElement.innerHTML = '';
        const rowCountElement = document.getElementById('rowCount');
        rowCountElement.textContent = '';
        // add new table rows
        let rowCount = 0;
        // document.write(secId)
        // get array of dates between from_date and to_date
        const fromDate = new Date(from_date);
        const toDate = new Date(to_date);
        const dates = [];
        for (let date = fromDate; date <= toDate; date.setDate(date.getDate() + 1)) {
          dates.push(new Date(date));
        }

        data.forEach(row => {
          const tableRow = document.createElement('tr');

  tableRow.innerHTML = `
    <td>${row.employee_id}<input type="hidden" name="id[]" value="${row.employee_id}" hidden></td>
    <td>${row.employee_name}<input type="hidden" name="name[]" value="${row.employee_name}" hidden></td>
    <td>${row.department_name}<input type="hidden" name="department_name[]" value="${row.department_name}" hidden></td>
    <td>${row.section_name}<input type="hidden" name="section_name[]" value="${row.section_name}" hidden></td>
    ${dates.map(date => `<td>${row[date.toISOString().slice(0, 10)] || ''}<input type="hidden" name="${date.toISOString().slice(0, 10)}[]" value="${row[date.toISOString().slice(0, 10)] || ''}" hidden></td>`).join('')}
  `;


          tableDataElement.appendChild(tableRow);
          rowCount++;
        });

       
             rowCountElement.textContent="Total Employee : "+rowCount;

          });
  }

  // function getSelectedDate() {
  //   const datePickerElement = document.getElementById('datePicker');
  //   return datePickerElement.value;
  // }
  function getFromDate() {
    const selectElement = document.getElementById('from_datePicker');

    return selectElement.value;
  }
  function getToDate() {
    const selectElement = document.getElementById('to_datePicker');

    return selectElement.value;
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


    var showDepartment = true;


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