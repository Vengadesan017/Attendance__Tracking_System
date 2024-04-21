<?php 
	include_once 'session.php';
	include_once 'header.php';
  include_once 'data.php';	
  $departments = display_department($_SESSION['user_id']);
  $sections = display_section($_SESSION['user_id']);
  $dep_names = json_encode($sections);

?>

<body>
	<?php include_once 'sidenav.php'; ?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      Exception Attendance
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
   var date = "' . $date. '"; 
   var shift = "' . $shift . '"; 
   var dep_id = "' . $dep_id . '";
   var sec_id = "' . $sec_id . '";
   var expire = "' . $_SESSION['expire'] . '";
   var start = "' . $_SESSION['start'] . '";
   var now = "' . time() . '";
   var dep_names = ' . $dep_names . ';
  </script>';

?>

 <div>

    <form method="post" action="<?php echo htmlspecialchars('data.php')?>">
        <div class="ribbon">

        <span id="rowCount" class="card"></span>
        

        <span id="a_rowCount" class="card"></span>
        

        <span id="v_rowCount" class="card"></span>
              

        <input type="date" id="datePicker" name="date" class="date">

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


        <div class="multipleSelection">
          <div class="selectBox" onclick="showCheckShift(event)">
            <select id="mySelectShift">
              <option>Shift</option>
            </select>
            <div class="overSelect"></div>
          </div>

          <div id="checkShift" class="m_select">
            <label >
              <input type="checkbox" onclick="Select_All_Shift(this)">
              Select all
            </label>
            <label >
              <input type="checkbox" value="G" id="5" class="shift">
              Shift G
            </label>
            
            <label>
              <input type="checkbox" value="A" id="12" class="shift">
              Shift A
            </label>
            <label >
              <input type="checkbox" value="B" id="13" class="shift">
              Shift B
            </label>
            <label>
              <input type="checkbox" value="C" id="14" class="shift">
              Shift C
            </label>
          </div>
        </div>

        <!-- <button name="approve">Approve</button> -->
      <button id="exportButton">Download</button>   
    </div>

    <div class="outer-wrapper">
    <div class="table-wrapper">
      <table id="myTable">
              <thead>
                <tr>
                  <!-- <th><input type="checkbox" class="select_all_items" id="select-all-checkbox">&nbsp;Employee Id</th> -->
                  <th>Employee Id</th>
                  <th>Name</th>
                  <th>Contractor</th>
                  <th>Category</th>
                  <th>Department</th>
                  <th>Section</th>
                  <th>Shift</th>
                  <th>Attendance</th>
                  <th>Status</th>
                  <th>In time</th>
                  <th>Out time</th>
                  <th>Remarks</th>
                  <th>Approved By</th>
                  <th>Verified By</th>
                </tr>
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
        
            
            <input type="hidden" name="file" value="department.php" hidden>
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
  
<script type="text/javascript">


var showShift = true;
var showSection = true;
var showDepartment = true;

document.getElementById("EditForm").style.display = "none";

  function openEdit() {
    document.getElementById("EditForm").style.display = "block";
  }


  function closeEdit() {
    document.getElementById("EditForm").style.display = "none";
  }
  if (date !== undefined && date !== null && date !== '') {

    // Set the value of the input field
    document.getElementById("datePicker").value = date;
  }
  else{
    let today = new Date();
    let day = today.getDate();
    let month = today.getMonth() + 1;
    let year = today.getFullYear();

    if (day < 10) {
      day = '0' + day;
    }
    if (month < 10) {
      month = '0' + month;
    }

    let formattedDate = year + '-' + month + '-' + day;
    document.getElementById('datePicker').value = formattedDate;
  }

  if (shift !== undefined && shift !== null && shift !== '') {
    

    // Split the shift string into an array of values

    var shiftValues = shift.split(',');
    // Check the checkboxes corresponding to the shift values
    shiftValues.forEach(function(value) {
      var checkbox = document.querySelector('.shift[id="' + value + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });
    display_Shift();
  }
  else{
    var currentTime = new Date();
    var currentHour = currentTime.getHours();


    if (currentHour >= 9 && currentHour < 17.30) {
      var checkbox = document.querySelector('.shift[id="' + 5 + '"]');
    } else if (currentHour >= 6 && currentHour < 14.30) {
      var checkbox = document.querySelector('.shift[id="' + 12 + '"]');
    } else if (currentHour >= 14.30 || currentHour < 23) {
      var checkbox = document.querySelector('.shift[id="' + 13 + '"]');
    } else if (currentHour >= 23 || currentHour < 6){
      var checkbox = document.querySelector('.shift[id="' + 14 + '"]');
    }
    checkbox.checked = true;
    display_Shift();

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
  

    var secValues = sec_id.split(',');

    secValues.forEach(function(value) {
      var checkbox = document.querySelector('.section[id="' + value + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });

    display_Section();
  }
  else{
    <?php foreach ($sections as $section): ?>
    var checkbox= document.querySelector('.section[id="' + '<?php echo($section['Section_id']); ?>' + '"]');
    checkbox.checked = true;

  <?php endforeach; ?>
  display_Section();
  }

  //For select all feature
  $(document).ready(function() {
    $('#select-all-checkbox').on('click', function() {
      $('input[name="checking[]"]').prop('checked', this.checked);
    });

    $('input[name="checking[]"]').on('click', function() {
      if (!this.checked) {
        $('#select-all-checkbox').prop('checked', false);
      } else {
        const allChecked = $('input[name="checking[]"]').toArray().every(c => c.checked);
        $('#select-all-checkbox').prop('checked', allChecked);
      }
    });
  });


document.getElementById('exportButton').addEventListener('click', function(event) {
    event.preventDefault();
    const table = document.getElementById('myTable');
    const rows = table.querySelectorAll('tr');

    var r1 = document.getElementById('rowCount').textContent;
    var r2 = document.getElementById('a_rowCount').textContent;
    var r3 = document.getElementById('v_rowCount').textContent;
    var date = document.getElementById('datePicker').value;
    var dep = document.getElementById('mySelectDepartment').value;
    var sec = document.getElementById('mySelectSection').value;
    var shift = document.getElementById('mySelectShift').value;

    let xlsContent = `${r1}\t${r2}\t${r3}\tDate: ${date}\tDepartment: ${dep}\tSection: ${sec}\tShift: ${shift}\n\n\n`;



      rows.forEach(function (row) {
        const cols = row.querySelectorAll('th');
        const rowData = Array.from(cols).map(col => col.textContent).join('\t'); // Use tab as separator
        xlsContent += rowData;
      });
    rows.forEach(function(row) {
        const cells = row.querySelectorAll('td');
        let rowData = '';

        cells.forEach(function(cell) {
            const input = cell.querySelector('input');
            if (input) {
                if (input.type === 'text') {
                  // for remark
                    rowData += input.value;
                } else {
                  // for EmployeeCode
                  rowData += cell.textContent.trim();
                }
            } else {
                // for other data's
                rowData += cell.textContent.trim();
            }
            rowData += '\t';
        });

        xlsContent += rowData + '\n';
    });

    const blob = new Blob([xlsContent], { type: 'application/vnd.ms-excel' });
    const today = new Date();
    const formattedDate = today.toISOString().slice(0, 10).replace(/-/g, '');
    const fileName = `AttendanceLogs${formattedDate}.xls`;
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = fileName;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});


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

  fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection());

  document.getElementById('datePicker').addEventListener('change', function() {

    fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection());
  });



    function showCheckShift() {
      var checkboxes = document.getElementById("checkShift");

      if (showShift) {
        checkboxes.style.display = "block";
        showShift= false;
      } else {
        
        checkboxes.style.display = "none";
        
        display_Shift();
        showShift = true;
        fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection());
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
        fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection());
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
        fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection());
        showSection = true;
        event.stopPropagation();
      }
    }


    document.addEventListener('click', function(event) {
        if (!event.target.closest(".selectBox") && !event.target.matches('input[type="checkbox"]')) {

          var Departmentdropdown = document.getElementById("checkDepartment");
          var Sectiondropdown = document.getElementById("checkSection");
          var shiftdropdown = document.getElementById("checkShift");

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
          if (showShift==false && !event.target.closest("#checkShift")){
            shiftdropdown.style.display = "none";
            showShift = true;  
            display_Shift();
          }

          if ((Departmentdropdown.style.display == "none" && Sectiondropdown.style.display == "none" && shiftdropdown.style.display == "none") && !(showDepartment==false || showShift==false || showSection==false)) {
            fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection());     
          }
        }

    });



  setInterval(function() {fetchTableData(getSelectedDate(),getSelectedShift(),getSelectedDepartment(),getSelectedSection())}, 60000);

  function fetchTableData(date,shift,dep_id,sec_id) {
    
    fetch(`data.php?e_date=${date}&e_shift=${shift}&e_dep_id=${dep_id}&e_sec_id=${sec_id}`)
      .then(response => response.json())
      .then(data => {


        const tableDataElement = document.getElementById('tableData');
        tableDataElement.innerHTML = '';

        const rowCountElement = document.getElementById('rowCount');
        rowCountElement.textContent='';
        let rowCount=0;

        const a_rowCountElement = document.getElementById('a_rowCount');
        a_rowCountElement.textContent='';
        let a_rowCount=0;

        const v_rowCountElement = document.getElementById('v_rowCount');
        v_rowCountElement.textContent='';
        let v_rowCount=0;

        data.forEach(row => {
         
            Object.keys(row).forEach((key) => {
              // Check if the value is null or undefined and assign an empty string if true
              if (row[key] == null || row[key] == undefined) {
                row[key] = '';
              }
            });

          const tableRow = document.createElement('tr');

          tableRow.innerHTML = `

                      <td>
                          <input type="hidden" name="id[]" value="${row.id}" hidden>

                          &nbsp;${row.EmployeeCode}
                      </td>

                      <td>${row.employee_name}

                      </td>

                      <td>${row.Contractor_name}
                          
                      </td>

                      <td>${row.Category}
                        
                      </td>
                      <td>${row.department_name}

                      </td>
                      <td>${row.Section_name}

                      </td>
                      <td>${row.Shift_name}
                      </td>  
                      <td>${row.Attendance}
                        </td>  
                        </td>                        
                      <td>${row.a_status}
                        </td>  
                        </td>
                      <td>${row.in_time.replace(/\.?0+$/,'')}
                        
                      </td>

                      <td>${row.out_time.replace(/\.?0+$/,'')}
                        
                      </td>

                      <td><input type="text" name="remarking[]" value="${row.remarks}" >
                        
                      </td>
                      <td>${row.approved_by}
                        </td>  
                      </td>
                      <td>${row.verified_by}
                        </td>  
                      </td>
                                       

          `;           

          tableDataElement.appendChild(tableRow);
          if(row.a_status === 'Approved'){a_rowCount++;}
          else if (row.a_status === 'Verified'){v_rowCount++; a_rowCount++;}

          rowCount++;
          
        });
        rowCountElement.textContent='Mismatch Present : '+rowCount;
        a_rowCountElement.textContent='Approved : '+a_rowCount;
        v_rowCountElement.textContent='Verified : '+v_rowCount;
      })
      .catch(error => console.error(error));
  }



function getSelectedDate() {
  const selectElement = document.getElementById('datePicker');
  return selectElement.value;
}

function getSelectedShift() {
  var s = [];
  var checkboxes = document.querySelectorAll("#checkShift input[type='checkbox']");
  
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

// ~~~~~~~~ Shift ~~~~~~~~
   



function Select_All_Shift(checkbox) {
  var checkboxes = document.querySelectorAll("#checkShift input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = checkbox.checked;
  }

  // var selectAllCheckbox = document.getElementById("selectAll");
  // selectAllCheckbox.checked = checkbox.checked;


}

function display_Shift() {
  var s = [];

  var checkboxes = document.querySelectorAll("#checkShift input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
      if (checkboxes[i].parentNode.innerText.trim() != "Select all") {
        s.push(checkboxes[i].value);
      }
    }
  }

  var selectBox = document.getElementById("mySelectShift");
  selectBox.options[0].text = s.join(", ") || "Shift";

}

// ~~~~~~~~ Section ~~~~~~~~




function Select_All_Section(checkbox) {
  var checkboxes = document.querySelectorAll("#checkSection input[type='checkbox']");
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = checkbox.checked;
  }

  // var selectAllCheckbox = document.getElementById("selectAll");
  // selectAllCheckbox.checked = checkbox.checked;


}
var sec = [];
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

// ~~~~~~~~ Department ~~~~~~~~
   


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