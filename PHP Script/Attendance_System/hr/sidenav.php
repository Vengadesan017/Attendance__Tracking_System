
  <div class="sidebar close">
    <div class="logo-details">

      <span class="logo_name"><img src="./../img/preethi_logo.png" title="Preethi" alt="Preethi" class="img-responsive" height="29.33" width="119.99"></span>  
    </div>
    <ul class="nav-links">
      <li>
        <a href="dashboard.php">
          <i class='bx bx-line-chart' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="dashboard.php">Dashboard</a></li>

        </ul>
      </li>

      <li>
        <a href="attendance.php">
          <i class='bx bx-calendar'></i>
          <span class="link_name">Attendance</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="attendance.php">Attendance</a></li>
        </ul>
      </li>
      <li>
        <a href="exception.php">
          <i class='bx bx-error-circle' ></i>
          <span class="link_name">Exception</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="exception.php">Exception</a></li>
        </ul>
      </li>
      <li>
        <a href="user.php">
          <i class='bx bx-user' ></i>
          <span class="link_name">User</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="user.php">User</a></li>
        </ul>
      </li>
<!--       <li>
        <a href="department.php">
          <i class='bx bx-collection' ></i>
          <span class="link_name">Department</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="department.php">Department</a></li>
        </ul>
      </li> -->
<!--       <li>
        <a href="section.php">
          <i class='bx bx-layout' ></i>
          <span class="link_name">Section</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="section.php">Section</a></li>
        </ul>
      </li> -->
      <li>
        <a href="workflow.php">
           <i class="bx bx-collection"></i>
          <span class="link_name">Work Flow</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="workflow.php">Work Flow</a></li>
        </ul>
      </li>
      <li>
        <a href="employee.php">
          <i class='bx bx-group'></i>
          <span class="link_name">Employee Master</span>
        </a>
        <ul class="sub-menu users">
          <li><a class="link_name" href="employee.php">Employee Master</a></li>
        </ul>
      </li>
      <li>
        <a href="download.php">
          <i class='bx bx-download'></i>
          <span class="link_name">Download</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="download.php">Download</a></li>
        </ul>
      </li>
      <li>
    <div class="profile-details">
      <div class="profile-content">
      
      </div>
      <div class="name-job"><a href="#" onclick="PasswordopenEdit()">
        <div class="profile_name"><?php echo($_SESSION['admin']); ?></div></a>
        <div class="job">HR</div>
      </div>
      <a href="./../logout.php">
        <i class='bx bx-log-out' ></i>
      </a>
    </div>
  </li>

</ul>

  </div>