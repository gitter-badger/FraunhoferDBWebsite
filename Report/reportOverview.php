<!DOCTYPE html>
<html>
<head>
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
  <title>Fraunhofer CCD</title>
  <link href='../css/bootstrap.min.css' rel='stylesheet'>
  <link href='../css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='../js/bootstrap.min.js'></script>
</head>
<body>
<?php include '../header.php'; ?>
  <div class='container'>
    <h1>Fraunhofer CCD</h1>
    <div class='row well well-lg'>
      <?php 
      if($user_sec_lvl >= 1){
        echo 
        "<div class='col-md-12 btn-group'>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='false''>View graphs and tables on financial data</button>
              <span class='sr-only'>Toggle Dropdown</span>
            </button>
            <ul class='dropdown-menu' role='menu'>
              <li><a href='databaseStatus.php'>The status of the database</a></li>
              <li><a href='filterReport.php'>Table for each company</a></li>
              <li><a href='geoData.php'>Where are our orders coming from</a></li>
              <li><a href='overall.php'>Overall for all customers </a></li>
              <li><a href='allCharts.php'>Line chart for each customer</a></li>
            </ul>
        </div>";
      }
      ?>
    </div>
  </div>
</body>
</html>
