<?php 
  include_once 'session.php';
  include_once 'header.php'; 
  include_once 'data.php'; 
  $sections=display_section($_SESSION['user_id']); 
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<body>
  <?php include_once 'sidenav.php'; ?>

    <section class="home-section">
      <div class="home-content">
        <i class='bx bx-menu' ></i>
        Dashboard
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


  // echo($_SESSION['date'] .$_SESSION['shift'] .$_SESSION['sec_ids']);

  echo '<script> 
   var from_date = "' . $from_date. '"; 
   var to_date = "' . $to_date . '"; 
   var expire = "' . $_SESSION['expire'] . '";
   var start = "' . $_SESSION['start'] . '";
   var now = "' . time() . '";
  </script>';

?>

  <div class="ribbon">
    <input type="date" id="from_datePicker" name="from_date" class="date">
    <input type="date" id="to_datePicker" name="to_date" class="date">

  </div>
    <div class="outer-wrapper">
    <div class="table-wrapper">
       <canvas id="myChart" ></canvas>
    </div>
  </div>




      <div class="form-popup" id="EditForm">
       
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
              <button type="button" onclick="closeEdit()" class="btn cancel">Cancel</button>
              <input type="submit" name="edit" value="Update password" class="btn create">
            </div>
          </form>

      </div>


    </section>

<script src="./../js/nav_bar.js"></script>
<script src="./../js/error.js"></script>
<script src="./../js/session_expire.js"></script>

<script type="text/javascript">

 
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



    document.getElementById('from_datePicker').addEventListener('change', function() {
      fetchChartData(getFromDate(), getToDate());
    });

    document.getElementById('to_datePicker').addEventListener('change', function() {
      fetchChartData(getFromDate(), getToDate());
    });
fetchChartData(getFromDate(), getToDate());
function fetchChartData(from_date, to_date) {
  fetch(`data.php?from_date=${from_date}&to_date=${to_date}`)
    .then(response => response.json())
    .then(data => {
      const labels = data.labels;

      // Extract data points from JSON

      const datasets = data.data.map((data ,index)=> {
        return {
          label: labels[index], // Use the first date as the label for the dataset
          data: data.map(item => item.row_count),
          borderColor: colors[index],
          fill: false
        };
      });


      let currentDate = new Date(from_date);
      const datesArray = []; // Array to store the dates

      const monthNames = [
        "jan", "feb", "mar", "apr", "may", "jun",
        "jul", "aug", "sep", "oct", "nov", "dec"
      ];

      while (currentDate <= new Date(to_date)) {
        const month = monthNames[currentDate.getMonth()];
        const day = currentDate.getDate();

        // Format the date as "day month" and push it to the datesArray
        datesArray.push(`${day} ${month}`);
        currentDate.setDate(currentDate.getDate() + 1);
      }

      // Create the chart
      new Chart("myChart", {
        type: "line",
        data: {
          labels: datesArray,
          datasets: datasets
        },
        options: {
          legend: { display: true },
          maintainAspectRatio: false, 
          responsive: true,
          aspectRatio: .8 , // Set the desired aspect ratio (width / height)
          scales: {
            xAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Date' // Replace with your desired x-axis label
              }
            }],
            yAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Verified head count' // Replace with your desired y-axis label
              }
            }]
          }// Set the desired aspect ratio (width / height)
        }
      });
    })
    .catch(error => console.error(error));
}



  const colors = [
  'rgb(255, 99, 132)',
  'rgb(54, 162, 235)',
  'rgb(255, 205, 86)',
  'rgb(75, 192, 192)',
  'rgb(153, 102, 255)',
  'rgb(255, 159, 64)',
  'rgb(255, 50, 50)',
  'rgb(0, 128, 0)',
  'rgb(0, 0, 255)',
  'rgb(128, 0, 128)',
  'rgb(0, 128, 128)',
  'rgb(128, 128, 0)',
  'rgb(255, 255, 0)',
  'rgb(0, 255, 255)',
  'rgb(255, 0, 255)',
  'rgb(128, 128, 128)', 
  'rgb(230, 25, 75)',
  'rgb(60, 180, 75)',
  'rgb(255, 225, 25)',
  'rgb(0, 130, 200)',
  'rgb(245, 130, 48)',
  'rgb(145, 30, 180)',
  'rgb(70, 240, 240)',
  'rgb(240, 50, 230)',
  'rgb(210, 245, 60)',
  'rgb(250, 190, 190)',
  'rgb(255, 99, 132)',
  'rgb(54, 162, 235)',
  'rgb(255, 205, 86)',
  'rgb(75, 192, 192)',
  'rgb(153, 102, 255)',
  'rgb(255, 159, 64)',
  'rgb(255, 50, 50)',
  'rgb(0, 128, 0)',
  'rgb(0, 0, 255)',
  'rgb(128, 0, 128)',
  'rgb(0, 128, 128)',
  'rgb(128, 128, 0)',
  'rgb(255, 255, 0)',
  'rgb(0, 255, 255)',
  'rgb(255, 0, 255)',
  'rgb(128, 128, 128)', 
  'rgb(230, 25, 75)',
  'rgb(60, 180, 75)',
  'rgb(255, 225, 25)',
  'rgb(0, 130, 200)',
  'rgb(245, 130, 48)',
  'rgb(145, 30, 180)',
  'rgb(70, 240, 240)',
  'rgb(240, 50, 230)',
  'rgb(210, 245, 60)',
  'rgb(250, 190, 190)',
  'rgb(10, 20, 30)',
  'rgb(150, 75, 0)',
  'rgb(100, 100, 100)',
  'rgb(200, 200, 200)',
  'rgb(255, 255, 255)'
];




function getFromDate() {
  const selectElement = document.getElementById('from_datePicker');

  return selectElement.value;
}
function getToDate() {
  const selectElement = document.getElementById('to_datePicker');

  return selectElement.value;
}

</script>
</body>
</html>