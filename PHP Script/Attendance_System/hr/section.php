<?php 
  include_once 'session.php';
  include_once 'header.php';
  include_once 'data.php';  
  $sections=display_section();
  $users=display_user();
  $deps=display_dep();
?>

<body>
  <?php include_once 'sidenav.php'; ?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      Section
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
  

    <div> 
      <button onclick="openUser()" class="btn new">New</button>
    </div>

    <div class="outer-wrapper">
    <div class="table-wrapper">
      <table>
              <thead>
                <tr>
                  <th>Department</th>
                  <th>Manager</th>
                  <th>Section ID</th>
                  <th>Section Name</th>
                  <th>Leader</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tableData">
                <?php  foreach($sections as $section): ?>
                  <tr>
                    <td><?php echo($section['department_name']); ?></td>
                    <td><?php echo($section['department_manager']); ?></td>
                    <td><?php echo($section['Section_id']); ?></td>
                    <td><?php echo($section['Section_name']); ?></td>
                    <td><?php echo($section['section_leader']); ?></td>

                

                     <td>
                     
                      <button onclick="openEdit('<?php echo $section['Section_id']; ?>', '<?php echo $section['Section_name']; ?>', '<?php echo $section['department_id']; ?>', '<?php echo $section['department_name']; ?>', '<?php echo $section['department_manager']; ?>', '<?php echo $section['leader_id']; ?>')" class="btn edit">Edit</button>

                    


                      <a href="delete_section.php?sec_id=<?php echo($section['Section_id']); ?>"><button class="btn delete">Delete</button></a>
                     </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </div>
      <div class="form-popup" id="CreateForm">
        <h1>Create New Section</h1>
          <form method="POST" action="create_section.php" class="form-container">
                  <label for="section_id">Section ID:</label>
                  <input type="number" name="section_id" id="section_id" name="section_id" placeholder="Enter the Section ID" required> 
                  <label for="department_name">Section Name:</label>             
                  <input type="text" name="section_name" id="section_name" name="section_name" placeholder="Enter the Section Name" required>   
                  <div class="button-container">                       
                    <button type="button" onclick="closeUser()" class="btn cancel">Close</button>
                    <input type="submit" name="create" class="btn create" value="Create">
                  </div>
        </form>
      </div>

      <div class="form-popup" id="EditForm">
        <h1 ><span id="sec_name"></span></h1> 
          <form method="POST" action="edit_section.php" class="form-container">

                  <input type="number" name="e_section_id" hidden>
                  <input type="hidden" name="before_e_section_name" hidden>
                  <input type="hidden" name="before_e_leader_id" hidden>
                  <input type="number" name="before_e_department_id" hidden>
                  <input type="hidden" name="before_e_manager_id" hidden>
                  

                  <label for="e_section_name">Section Name:</label>              
                  <input type="text" name="e_section_name" placeholder="Enter the Section Name">  
                  <label for="leader_name">Section Leader:</label>              
                  <select name="leader_name">
                    <?php  foreach($users as $user): ?>
                      <option value="<?php echo($user['user_id']); ?>"><?php echo($user['username']); ?></option>

                    <?php endforeach; ?>
                  </select>                        
                  <label for="department_name">Department:</label>              
                  <select name="department_name">
                    <?php  foreach($deps as $dep): ?>
                      <option value="<?php echo($dep['department_id']); ?>"><?php echo($dep['department_name']); ?></option>

                    <?php endforeach; ?>
                  </select> 
                  <div class="button-container">     
                    <button type="button" onclick="closeEdit()" class="btn cancel">Cancel</button>
                    <input type="submit" name="edit" value="Save" class="btn create">
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

  document.getElementById("CreateForm").style.display = "none";
  document.getElementById("EditForm").style.display = "none";

  function openUser() {
    document.getElementById("CreateForm").style.display = "block";
  }

  function closeUser() {
    document.getElementById("CreateForm").style.display = "none";
  }

  document.getElementById("EditForm").style.display = "none";

  function openEdit(sec_id,sec_name,dep_id,dep_name,manager_id,leader_id) {

    document.getElementById("sec_name").innerHTML = 'Edit Section : '+sec_name;
    document.getElementsByName("e_section_id")[0].value = sec_id;
    document.getElementsByName("before_e_section_name")[0].value = sec_name;
    document.getElementsByName("before_e_leader_id")[0].value = leader_id; 
    document.getElementsByName("before_e_department_id")[0].value = dep_id;   
    document.getElementsByName("before_e_manager_id")[0].value = manager_id;

    document.getElementsByName("e_section_name")[0].value = sec_name;
    document.querySelector("select[name='leader_name']").value = leader_id;
    document.querySelector("select[name='department_name']").value = dep_id;

    // document.getElementsByName("manager_name")[0].value = manager_id;

    document.getElementById("EditForm").style.display = "block";
  }

  function closeEdit() {
    document.getElementById("EditForm").style.display = "none";
  }



  document.addEventListener("DOMContentLoaded", function() {
  var closeButtons = document.querySelectorAll(".alert.alert-dismissible .close");
  for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].addEventListener("click", function() {
      var alertDiv = this.parentElement;
      alertDiv.style.display = "none";
    });
  }
});



</script>

</body>
</html>



