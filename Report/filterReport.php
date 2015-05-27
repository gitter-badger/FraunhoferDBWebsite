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
  <link href='../css/main.css' rel='stylesheet'> 
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script type="text/javascript" src='../js/report.js'></script>
</head>
<body>
  <?php include '../header.php'; ?>
  <div class='container'>
    <div class='row well well-lg col-md-3'>
      <h4>Fill out the form to fetch your data</h4>
      <div class='col-md-12'>
        <div>Pick a customer</div>
        <select id='customer_select'>
          <option value="%">All customers: </option> 
          <?php
          $sql = "SELECT customer_ID, customer_name 
                  FROM customer;";
          $result = mysqli_query($link, $sql);
          if (!$result) 
          {
            die("Database query failed: " . mysqli_error($link));
          }
          while($row = mysqli_fetch_array($result))
          {
            echo '<option value="'.$row['customer_ID'].'">'.$row['customer_name'].'</option>';
          }
          ?>
        </select>
      </div>
      <div class='col-md-12'>
        <div>From:</div>
        <input type="date" name="datefirst" id="search_box_date_first"/>
      </div>
      <div class='col-md-12'>
        <p>To:</p>
        <input type="date" name="datelast" id="search_box_date_last"/>
      </div>
      <div class='col-md-12'>
        <button class='btn btn-primary' onclick='resetFilter();'>Reset</button>
        <button class='btn btn-success' onclick='applyFilter();'>Apply</button>
      </div>
    </div>
    <div class='row well well-lg col-md-8 col-md-offset-1'>
      <div id='output'>
      </div>
    </div>
  </div>   
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>