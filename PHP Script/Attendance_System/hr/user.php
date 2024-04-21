<?php 
	include_once 'session.php';
	include_once 'header.php';  
	include_once 'create_user.php';

?>

<body>
	<?php 
		include_once 'sidenav.php';
     	$users=display();
      $login_users=json_encode(display_login());     
    ?>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      Users
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
   var login_users = ' . $login_users . ';
   var now = "' . time() . '";
  </script>';

?>
      <div class="form-popup" id="CreateForm">
        <h1>Create New User</h1>
        <form method="POST" action="create_user.php" class="form-container">
          <label for="user_id">User ID:</label>
          <input type="number" id="user_id" name="user_id" placeholder="Enter User ID" required  list="similarIds">              
          <datalist id="similarIds"></datalist>

          <label for="user_name">Username:</label>
          <input type="text" id="user_name" name="user_name" placeholder="Enter Username" required>                  


          <label for="user_department">Department:</label>
          <input type="text" id="user_department" name="user_department" placeholder="Enter Department" required>

          <label for="user_login">Login Type:</label>
          <select id="user_login" name="user_login">
            <option value="1">Department</option>
            <option value="2">Finance</option>
            <option value="3">Contractor</option>
            <option value="4">HR</option>
          </select>
          <div class="button-container">
          <button type="button" class="btn cancel" onclick="closeUser()">Close</button>
          <input type="submit" class="btn create" name="create" value="Create">
        </div>
        </form>
      </div>
    <div class="ribbon">
              <button onclick="openUser()" class="btn">New</button>
              <input type="search" id="searchInput" class="custom-input" onkeyup="myFunction()" placeholder="Search..">
    </div>
    <div class="outer-wrapper">
    <div class="table-wrapper">
      <table>
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>User Name</th>
                  <th>Department</th>
                  <th>Login Type</th>
                  <th>Action</th>                  
                </tr>
              </thead>
              <tbody id="tableData">

        <?php foreach($users as $user): ?>
        <tr>
          <td><?php echo($user['user_id']); ?></td>
         <td><?php echo($user['username']); ?></td>
         <td><?php echo($user['department']); ?></td>
         <td><?php echo($user['login_name']); ?></td>
         <td>
         <a href="#"><button onclick="openEdit(<?php echo($user['user_id']); ?>,'<?php echo($user['username']); ?>','<?php echo($user['department']); ?>',<?php echo($user['login_id']); ?>)" class="btn edit">Edit</button></a>

         	<a href="delete_user.php?user_id=<?php echo($user['user_id']); ?>"><button class="btn delete">Delete</button></a>
         </td>
        </tr>
        <?php endforeach; ?>
        
              </tbody>
            </table>
        </div>
    </div>

      <div class="form-popup" id="EditForm">
        <h1 ><span id="edit_user_name"></span></h1> 

          <form method="POST" action="edit_user.php" class="form-container">
            <input type="number" name="e_user_id" hidden>
            <input type="number" name="before_e_user_login" hidden> 
            <label for="e_user_name">User Name:</label>
            <input type="text" name="e_user_name" id="e_user_name" placeholder="Enter the username">
            <label for="e_user_department">Department:</label>
            <input type="text" name="e_user_department" id="e_user_department" placeholder="Enter the department">
            <label for="e_user_login">Login Type:</label>
            <select name="e_user_login" id="e_user_login">
              <option value="1">Department</option>
              <option value="2">Finance</option>
              <option value="3">Contractor</option>
              <option value="4">HR</option>
            </select>
  <div class="checkbox-container">
    <input type="checkbox" id="reset_password" name="reset_password">
    <label for="reset_password">Reset Password</label>
  </div>
            <div class="button-container">
              <button type="button" onclick="closeEdit()" class="btn cancel">Close</button>
              <input type="submit" name="edit" value="Edit" class="btn create">
            </div>
          </form>



      </div>
      </div>

      <div class="form-popup" id="PasswordEditForm">
       
        <h1>Change Password</h1>
          <form method="POST" action="edit_profile.php" class="form-container">
        
            
              <input type="hidden" name="file" value="user.php" hidden>
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

	document.getElementById("CreateForm").style.display = "none";
	document.getElementById("EditForm").style.display = "none";

  document.getElementById("PasswordEditForm").style.display = "none";

  function PasswordopenEdit() {
    document.getElementById("PasswordEditForm").style.display = "block";
  }


  function PasswordcloseEdit() {
    document.getElementById("PasswordEditForm").style.display = "none";
  }

	function openUser() {
	  document.getElementById("CreateForm").style.display = "block";
	}

	function closeUser() {
	  document.getElementById("CreateForm").style.display = "none";
	}

	document.getElementById("EditForm").style.display = "none";
	function openEdit(id,name,department,login_type) {
    document.getElementsByName("e_user_id")[0].value = id;
    document.getElementsByName("before_e_user_login")[0].value = login_type;
   document.getElementById("edit_user_name").innerHTML = 'Edit User : '+name;
    document.getElementsByName("e_user_name")[0].value = name;
    document.getElementsByName("e_user_department")[0].value = department;
    document.getElementsByName("e_user_login")[0].value = login_type;
	  document.getElementById("EditForm").style.display = "block";
	}

	function closeEdit() {
	  document.getElementById("EditForm").style.display = "none";
	}


// for creating the new user
function displayData(id) {
  const dataDisplay = document.getElementById('dataDisplay');
  const user_name = document.getElementById('user_name');
  const user_department = document.getElementById('user_department');  
  const userData = login_users[id];
  if (userData) {
    const { name,department } = userData;
    user_name.value = name;
    user_department.value = department;    
  } else {
    user_name.value = '';
    user_department.value = '';   
  }
}

// Function to find similar IDs
function findSimilarIds(enteredId) {
  const similarIds = Object.keys(login_users).filter((id) => id.startsWith(enteredId));
  return similarIds;
}

const user_id = document.getElementById('user_id');
user_id.addEventListener('input', function () {
  const enteredId = this.value;
  const similarIds = findSimilarIds(enteredId);


  const similarIdsDatalist = document.getElementById('similarIds');
  similarIdsDatalist.innerHTML = '';
  similarIds.forEach((id) => {
    const option = document.createElement('option');
    option.value = id;
    similarIdsDatalist.appendChild(option);
  });


  displayData(enteredId);
});



function myFunction() {
  var input, filter, table, tr, td_id, td_name, i, id_Value, name_Value,td_dep,td_type,dep_Value,type_Value;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableData");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td_id = tr[i].getElementsByTagName("td")[0];
    td_name = tr[i].getElementsByTagName("td")[1];
    td_dep = tr[i].getElementsByTagName("td")[2];
    td_type = tr[i].getElementsByTagName("td")[3];    
    if (td_id && td_name && td_dep && td_type) {
      id_Value = td_id.textContent || td_id.innerText;
      name_Value = td_name.textContent || td_name.innerText;  
      dep_Value = td_dep.textContent || td_dep.innerText;
      type_Value = td_type.textContent || td_type.innerText;  

      if (id_Value.toUpperCase().indexOf(filter) > -1 || name_Value.toUpperCase().indexOf(filter) > -1 || dep_Value.toUpperCase().indexOf(filter) > -1 || type_Value.toUpperCase().indexOf(filter) > -1 ) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}



</script>
</body>
</html>