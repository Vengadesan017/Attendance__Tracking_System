<?php 
  include_once 'session.php';
  include_once 'header.php';
  include_once 'data.php';  
  $sections=display_section_WF();
  $users=display_user();
  $locs=display_loc();
  $divs=display_div();
  $deps=display_dep();
  $secs=display_sec();


?>

<body>
  <?php include_once 'sidenav.php'; ?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      Work Flow
    </div>
 <div>
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
  </script>';

?>
  

    <div class="ribbon"> 
      <button onclick="openLocation()">New Location</button>
      <button onclick="openDivision()">New Division</button>
      <button onclick="openDepartment()">New Department</button>
      <button onclick="openSection()">New Section</button>  
      <input type="search" id="searchInput" class="custom-input" onkeyup="myFunction()" placeholder="Search..">      
      <button id="exportButton">Download</button>    

    </div>

    <div class="outer-wrapper">
    <div class="table-wrapper">
      <table id="myTable">
              <thead>
                <tr>
                  <th>Location</th>                   
                  <th>Division</th>            
                  <th>Department</th>
                  <th>Section</th>
                  <th>Department Manager</th>
                  <th>Section Leader</th>
                  <th>Action</th>
                </tr>
              </thead>
               <tbody id="tableData">
                <?php  foreach($sections as $section): ?>
                  <tr>
                    <td><?php echo($section['location_name']); ?></td>  
                    <td><?php echo($section['division_name']); ?></td>  
                    <td><?php echo($section['department_name']); ?></td>
                    <td><?php echo($section['Section_name']); ?></td>                    
                    <td><?php echo($section['department_manager']); ?></td>
                    <td><?php echo($section['section_leader']); ?></td>

                

                     <td>
                     
                      <button onclick="openEdit('<?php echo $section['location_id']; ?>', '<?php echo $section['location_name']; ?>', '<?php echo $section['division_id']; ?>', '<?php echo $section['division_name']; ?>','<?php echo $section['Section_id']; ?>', '<?php echo $section['Section_name']; ?>', '<?php echo $section['department_id']; ?>', '<?php echo $section['department_name']; ?>', '<?php echo $section['department_username_id']; ?>', '<?php echo $section['leader_id']; ?>')" class="btn edit">Edit</button>

                      <button onclick="openDelete('<?php echo $section['location_id']; ?>', '<?php echo $section['location_name']; ?>', '<?php echo $section['division_id']; ?>', '<?php echo $section['division_name']; ?>','<?php echo $section['Section_id']; ?>', '<?php echo $section['Section_name']; ?>', '<?php echo $section['department_id']; ?>', '<?php echo $section['department_name']; ?>', '<?php echo $section['department_username_id']; ?>', '<?php echo $section['leader_id']; ?>', '<?php echo $section['department_manager']; ?>', '<?php echo $section['section_leader']; ?>')" class="btn delete">Delete</button>                    


                      <!-- <a href="delete_section.php?sec_id=<?php echo($section['Section_id']); ?>"><button class="btn delete">Delete</button></a> -->
                     </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </div>


      <div class="form-popup" id="CreateLocation">
        <h1>Create New Location</h1>
          <form method="POST" action="create_section.php" class="form-container">

                  <label for="location_name">Location Name:</label>             
                  <input type="text" name="location_name" id="location_name" name="location_name" placeholder="Enter the Location Name" required>   
                  <div class="button-container">                       
                    <button type="button" onclick="closeLocation()" class="btn cancel">Close</button>
                    <input type="submit" name="CreateLocation" class="btn create" value="Create">
                  </div>
        </form>
      </div>

      <div class="form-popup" id="CreateDivision">
        <h1>Create New Division</h1>
          <form method="POST" action="create_section.php" class="form-container">

                  <label for="division_name">Division Name:</label>             
                  <input type="text" name="division_name" id="division_name" name="division_name" placeholder="Enter the Division Name" required>   
                  <label for="location_name">Select location:</label>              
                  <select name="location_name">
                    <option value='-1'>None of below</option>
                    <?php  foreach($locs as $loc): ?>
                      <option value="<?php echo($loc['location_id']); ?>"><?php echo($loc['location_name']); ?></option>

                    <?php endforeach; ?>
                  </select> 

                  <div class="button-container">                       
                    <button type="button" onclick="closeDivision()" class="btn cancel">Close</button>
                    <input type="submit" name="CreateDivision" class="btn create" value="Create">
                  </div>
        </form>
      </div>

      <div class="form-popup" id="CreateDepartment">
        <h1>Create New Department</h1>
          <form method="POST" action="create_section.php" class="form-container">

                  <label for="department_name">Department Name:</label>             
                  <input type="text" name="department_name" id="department_name" name="department_name" placeholder="Enter the Department Name" required>   
                  <label for="division_name">Select Division:</label>  
                  <select name="division_name">
                    <option value='-1'>None of below</option>
                    <?php  foreach($divs as $div): ?>
                      <option value="<?php echo($div['division_id']); ?>"><?php echo($div['division_name']); ?></option>

                    <?php endforeach; ?>
                  </select>                   
                  <div class="button-container">                       
                    <button type="button" onclick="closeDepartment()" class="btn cancel">Close</button>
                    <input type="submit" name="CreateDepartment" class="btn create" value="Create">
                  </div>
        </form>
      </div>

      <div class="form-popup" id="CreateSection">
        <h1>Create New Section</h1>
          <form method="POST" action="create_section.php" class="form-container">
                  <label for="department_name">Section Name:</label>             
                  <input type="text" name="section_name" id="section_name" name="section_name" placeholder="Enter the Section Name" required>  

                  <label for="department_name">Select Department:</label>  
                  <select name="department_name">
                    <option value='-1'>None of below</option>
                    <?php  foreach($deps as $dep): ?>
                      <option value="<?php echo($dep['department_id']); ?>"><?php echo($dep['department_name']); ?></option>

                    <?php endforeach; ?>
                  </select>     
                  <div class="button-container">                       
                    <button type="button" onclick="closeSection()" class="btn cancel">Close</button>
                    <input type="submit" name="CreateSection" class="btn create" value="Create">
                  </div>
        </form>
      </div>

      <div class="form-popup" id="EditForm">
        <h1 ><span id="sec_name"></span></h1> 
          <form method="POST" action="edit_section.php" class="form-container">

                  <!-- <input type="number" name="e_section_id" hidden> -->
                  <input type="number" name="before_e_location_id" hidden>
                  <input type="number" name="before_e_division_id" hidden>
                  <input type="number" name="before_e_department_id" hidden>                  
                  <input type="hidden" name="before_e_section_id" hidden>

                  <input type="hidden" name="before_e_manager_id" hidden>
                  <input type="hidden" name="before_e_leader_id" hidden>                  


                  <label for="location_name1">Location:</label>              
                  <select name="location_name1">
                    <?php  foreach($locs as $loc): ?>
                      <option value="<?php echo($loc['location_id']); ?>"><?php echo($loc['location_name']); ?></option>

                    <?php endforeach; ?>
                  </select>                        
                  <label for="divsion_name">Division:</label>              
                  <select name="divsion_name">
                    <?php  foreach($divs as $div): ?>
                      <option value="<?php echo($div['division_id']); ?>"><?php echo($div['division_name']); ?></option>

                    <?php endforeach; ?>
                  </select> 

                  <label for="department_name1">Department:</label>              
                  <select name="department_name1">
                    <?php  foreach($deps as $dep): ?>
                      <option value="<?php echo($dep['department_id']); ?>"><?php print_R($dep['department_name']); ?></option>

                    <?php endforeach; ?>
                  </select>                         
                  <label for="section_name">Section:</label>              
                  <select name="section_name">
                    <?php  foreach($secs as $sec): ?>
                      <option value="<?php echo($sec['Section_id']); ?>"><?php echo($sec['Section_name']); ?></option>

                    <?php endforeach; ?>
                  </select>                   
                  <label for="manager_name">Department Manager:</label>              
                  <select name="manager_name">
                    <?php  foreach($users as $user): ?>
                      <option value="<?php echo($user['user_id']); ?>"><?php echo($user['username']); ?></option>

                    <?php endforeach; ?>
                  </select>                        
                  <label for="leader_name">Section Leader:</label>              
                  <select name="leader_name">
                    <?php  foreach($users as $user): ?>
                      <option value="<?php echo($user['user_id']); ?>"><?php echo($user['username']); ?></option>

                    <?php endforeach; ?>
                  </select>  
                  <div class="button-container">     
                    <button type="button" onclick="closeEdit()" class="btn cancel">Cancel</button>
                    <input type="submit" name="edit" value="Save" class="btn create">
                  </div>
        </form>
      </div>
      <div class="form-popup" id="DeleteForm">
        <h1 >Select what to Delete</h1> 
          <form method="POST" action="delete_section.php" class="form-container">

                  <input type="number" name="before_d_location_id" hidden>
                  <input type="number" name="before_d_division_id" hidden>
                  <input type="number" name="before_d_department_id" hidden>                  
                  <input type="hidden" name="before_d_section_id" hidden>

                  <input type="hidden" name="before_d_manager_id" hidden>
                  <input type="hidden" name="before_d_leader_id" hidden>                  


                  <!-- <input type="number" name="e_section_id" hidden> -->
                  <label class="checkbox-inline"><input type="checkbox" name="d_location_id" value="Location"> Location : <span id="d_l_name"></span></label>    
                  <label class="checkbox-inline"><input type="checkbox" name="d_division_id" value="Division"> Division : <span id="d_dv_name"></span></label>    
                  <label class="checkbox-inline"><input type="checkbox" name="d_department_id" value="Department"> Department : <span id="d_d_name"></span></label>                      
                  <label class="checkbox-inline"><input type="checkbox" name="d_section_id" value="Section"> Section : <span id="d_s_name"></span></label>    

                  <label class="checkbox-inline"><input type="checkbox" name="d_manager_id" value="manager"> Unmap department manager : <span id="d_dm_name"></span></label>    
                  <label class="checkbox-inline"><input type="checkbox" name="d_leader_id" value="leader"> Unmap section leader : <span id="d_sl_name"></span></label>                      

                  <div class="button-container">     
                    <button type="button" onclick="closeDelete()" class="btn create">Cancel</button>
                    <input type="submit" name="Delete" value="Delete" class="btn cancel">
                  </div>
        </form>
      </div>
    </div>

      <div class="form-popup" id="PasswordEditForm">
       
        <h1>Change Password</h1>
          <form method="POST" action="edit_profile.php" class="form-container">
        
            
              <input type="hidden" name="file" value="section.php" hidden>
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

  document.getElementById("PasswordEditForm").style.display = "none";

  function PasswordopenEdit() {
    document.getElementById("PasswordEditForm").style.display = "block";
  }


  function PasswordcloseEdit() {
    document.getElementById("PasswordEditForm").style.display = "none";
  }



  document.getElementById("EditForm").style.display = "none";

  function openLocation() {
    document.getElementById("CreateLocation").style.display = "block";
  }

  function closeLocation() {
    document.getElementById("CreateLocation").style.display = "none";
  }

  function openDivision() {
    document.getElementById("CreateDivision").style.display = "block";
  }

  function closeDivision() {
    document.getElementById("CreateDivision").style.display = "none";
  }

  function openDepartment() {
    document.getElementById("CreateDepartment").style.display = "block";
  }

  function closeDepartment() {
    document.getElementById("CreateDepartment").style.display = "none";
  }
  function openSection() {
    document.getElementById("CreateSection").style.display = "block";
  }

  function closeSection() {
    document.getElementById("CreateSection").style.display = "none";
  }
  document.getElementById("EditForm").style.display = "none";

  function openEdit(loc_id,loc_name,div_id,div_name,sec_id,sec_name,dep_id,dep_name,manager_id,leader_id) {


    document.getElementById("sec_name").innerHTML = 'Edit Section : '+sec_name;
    // document.getElementsByName("e_section_id")[0].value = sec_id;
    // document.getElementsByName("before_e_section_name")[0].value = sec_name;
    document.getElementsByName("before_e_leader_id")[0].value = leader_id; 
    document.getElementsByName("before_e_manager_id")[0].value = manager_id;

    document.getElementsByName("before_e_location_id")[0].value = loc_id;
    document.getElementsByName("before_e_division_id")[0].value = div_id;
    document.getElementsByName("before_e_department_id")[0].value = dep_id;       
    document.getElementsByName("before_e_section_id")[0].value = sec_id;


    // document.getElementsByName("e_section_name")[0].value = sec_name;

    document.querySelector("select[name='manager_name']").value= manager_id;
    document.querySelector("select[name='leader_name']").value = leader_id;

    document.querySelector("select[name='location_name1']").value = loc_id;
    document.querySelector("select[name='divsion_name']").value = div_id;
    document.querySelector("select[name='department_name1']").value = dep_id;
    document.querySelector("select[name='section_name']").value = sec_id;



    document.getElementById("EditForm").style.display = "block";
  }

  function closeEdit() {
    document.getElementById("EditForm").style.display = "none";
  }

  function openDelete(loc_id,loc_name,div_id,div_name,sec_id,sec_name,dep_id,dep_name,manager_id,leader_id,manager_name,leader_name) {







    // document.getElementsByName("e_section_id")[0].value = sec_id;
    // document.getElementsByName("before_e_section_name")[0].value = sec_name;
    document.getElementsByName("before_d_leader_id")[0].value = leader_id; 
    document.getElementsByName("before_d_manager_id")[0].value = manager_id;

    document.getElementsByName("before_d_location_id")[0].value = loc_id;
    document.getElementsByName("before_d_division_id")[0].value = div_id;
    document.getElementsByName("before_d_department_id")[0].value = dep_id;       
    document.getElementsByName("before_d_section_id")[0].value = sec_id;


    // document.getElementsByName("e_section_name")[0].value = sec_name;

    document.querySelector("select[name='manager_name']").value= manager_id;
    document.querySelector("select[name='leader_name']").value = leader_id;

    document.querySelector("select[name='location_name1']").value = loc_id;
    document.querySelector("select[name='divsion_name']").value = div_id;
    document.querySelector("select[name='department_name1']").value = dep_id;
    document.querySelector("select[name='section_name']").value = sec_id;

    document.getElementById("d_l_name").innerHTML =loc_name;
    document.getElementById("d_dv_name").innerHTML =div_name;
    document.getElementById("d_d_name").innerHTML =dep_name;
    document.getElementById("d_s_name").innerHTML =sec_name;
    document.getElementById("d_dm_name").innerHTML =manager_name;
    document.getElementById("d_sl_name").innerHTML =leader_name;


    document.getElementById("DeleteForm").style.display = "block";
  }

  function closeDelete() {
    document.getElementById("DeleteForm").style.display = "none";
  }

function myFunction() {
  var input, filter, table, tr, loc, div, dep, sec, man, lea, i, loc_v, div_v, dep_v, sec_v, man_v, lea_v;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableData");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    loc = tr[i].getElementsByTagName("td")[0];
    div = tr[i].getElementsByTagName("td")[1];
    dep = tr[i].getElementsByTagName("td")[2];
    sec = tr[i].getElementsByTagName("td")[3];
    man = tr[i].getElementsByTagName("td")[4];
    lea = tr[i].getElementsByTagName("td")[5];


    if (loc && div && dep&& sec&& man&& lea) {
      loc_v = loc.textContent || loc.innerText;
      div_v = div.textContent || div.innerText;  
      dep_v = dep.textContent || dep.innerText;
      sec_v = sec.textContent || sec.innerText;  
      man_v = man.textContent || man.innerText;
      lea_v = lea.textContent || lea.innerText;            
      if (loc_v.toUpperCase().indexOf(filter) > -1 || div_v.toUpperCase().indexOf(filter) > -1 ||dep_v.toUpperCase().indexOf(filter) > -1 || sec_v.toUpperCase().indexOf(filter) > -1||man_v.toUpperCase().indexOf(filter) > -1 || lea_v.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
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
      const fileName = `WorkFlowLogs${formattedDate}.xls`; // Create file name with formatted date
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = fileName; // Use the new file name
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    });

</script>

</body>
</html>



