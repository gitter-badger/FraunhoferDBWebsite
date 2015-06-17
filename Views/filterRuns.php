<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT security_level
           FROM employee
           WHERE employee_name = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type="text/javascript" src='../js/searchScript.js'></script>
</head>
<body>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg col-md-12'>
      <h4>Enter info to search for a run</h4>
      <!-- <p>Use '_' to represent a single character or use '%' to represent a string of characters</p> -->
      <!-- <p>K215_____1 would for example find all first runs of the day for 2015 on K2</p> -->
      <p class='col-md-3'>
        <span>From:</span>
        <input type="date" name="datefirst" id="search_box_date_first" onchange='run_suggestions()'/>
      </p>
      <p class='col-md-3'>
        <span>To:</span>
        <input type="date" name="datelast" id="search_box_date_last" onchange='run_suggestions()'/>
      </p>
      <p class='col-md-3'>
        <span>AH/Pulses:</span>
        <input type="text" name="ah/pulses" id="search_box_ah" onkeyup='run_suggestions()'/>
      </p>

      <p class='col-md-6'>
        <span>Run number:</span>
        <input type="text" name="run_number" id="search_box_run" class='search_box' onkeyup='run_suggestions()'/>
      </p>
      <p class='col-md-3'>
        <span>Machine</span>
        <select id='machine_select' onchange='run_suggestions()'>
          <option value="">All machines: </option> 
          <?php
            $sql = "SELECT machine_ID, machine_acronym 
                    FROM machine;";
            $result = mysqli_query($link, $sql);
            if (!$result) 
            {
              die("Database query failed: " . mysqli_error($link));
            }
            while($row = mysqli_fetch_array($result))
            {
              echo '<option value="'.$row['machine_ID'].'">'.$row['machine_acronym'].'</option>';
            }
          ?>
        </select>
      </p>
        <p class='col-md-3'>
        <span>Coating</span>
        <select id='coating_select' onchange='run_suggestions()'>
          <option value="">All coatings: </option> 
          <?php
            $sql = "SELECT coating_ID, coating_type 
                    FROM coating;";
            $result = mysqli_query($link, $sql);
            if (!$result) 
            {
              die("Database query failed: " . mysqli_error($link));
            }
            while($row = mysqli_fetch_array($result))
            {
              echo '<option value="'.$row['coating_ID'].'">'.$row['coating_type'].'</option>';
            }
          ?>
        </select>
      </p>
    </div>
    <div id='test'><span></span></div>
    <table id='output'>
    </table>
  </div>   
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>