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
  <!-- <link href='../css/main.css' rel='stylesheet'> -->
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/searchScript.js'></script>
</head>
<body>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg'>
      <h4>Enter info to search for a run</h4>
      <div class='col-md-3'>
        <p >Input the run number</p>
        <input type="text" name="run_number" id="search_box_run" class='search_box' onkeyup='run_suggestions()'/>
      </div>
      <div class='col-md-3'>
        <p>Pick a machine</p>
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
      </div>
      <div class='col-md-3'>
        <p>From:</p>
        <input type="date" name="datefirst" id="search_box_date_first" onchange='run_suggestions()'/>
      </div>
      <div class='col-md-3'>
        <p>To:</p>
        <input type="date" name="datelast" id="search_box_date_last" onchange='run_suggestions()'/>
      </div>
    </div>
    <div id='test'><span></span></div>
    <table id='output'>
    </table>
  </div>   
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>