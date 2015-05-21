<!-- In this view we only display some parts if the security level is high enough -->
<!DOCTYPE html>
<html>
<head>
  <?php
  include 'connection.php';
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
  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='css/main.css' rel='stylesheet'>
  <script type="text/javascript" src='js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='js/bootstrap.min.js'></script>
</head>
<body>
<?php include 'header.php'; ?>
  <div class='container'>
    <h1>Fraunhofer CCD</h1>
    <div class='row well well-lg'>
      <div class='col-md-3 btn-group'>
          <!-- <input type="submit" class='btn btn-primary' value="Tooling overview"> -->
          <button type='button' class='btn btn-primary' onclick="location.href='Views/overview.php'">Tooling overview</button>
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="Printouts/printPO.php" target="_blank">Print out General overviews</a></li>
            <li><a href="Printouts/printTrackSheet.php" target="_blank">Print out track sheet</a></li>
            <li><a href="Views/filterPOS.php">Search for POS</a></li>
          </ul>
      </div>
      <?php 
      if($user_sec_lvl >= 2){
        echo 
        "<div class='col-md-3 btn-group'>
            <button type='button' class='btn btn-primary' onclick="."location.href"."='Views/checkin.php'>Check in tools</button>
            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
              <span class='caret'></span>
              <span class='sr-only'>Toggle Dropdown</span>
            </button>
            <ul class='dropdown-menu' role='menu'>
              <li><a href='Views/addNewPO.php'>Add a new PO</a></li>
              <li><a href='Views/addTools2.php'>Add tools to PO</a></li>
              <li><a href='Views/generateTrackSheet.php'>Generate a tracksheet</a></li>
              <li class='divider'></li>
              <li><a href='DeletePHP/deletePO.php'>Delete PO</a></li>
            </ul>
        </div>";
      }
      ?>

      <?php 
      if($user_sec_lvl >= 1){
        echo 
        "<div class='col-md-3 btn-group'>
        <button type='button' class='btn btn-primary' onclick="."location.href"."='Views/addOrEdit.php'>General information</button>
        <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
          <span class='caret'></span>
          <span class='sr-only'>Toggle Dropdown</span>
        </button>
        <ul class='dropdown-menu' role='menu'>
          <li><a href='Views/viewAllCustomers.php'>Customer info</a></li>
          <li><a href='Views/viewAllEmployees.php'>Employee info</a></li>
          <li><a href='Views/viewAllMachines.php'>Machine info</a></li>
          <li><a href='Views/viewAllCoatings.php'>Coating info</a></li>
        </ul>
        </div>";
      }
      ?>
      <?php
      if($user_sec_lvl >= 4){
        echo
        "<div class='col-md-3 btn-group'>
        <button type='button' class='btn btn-primary'>Financial data</button>
        <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
          <span class='glyphicon glyphicon-euro'></span>
          <span class='sr-only'>Toggle Dropdown</span>
        </button>
        <ul class='dropdown-menu' role='menu'>
          <li><a>Money Trees</a></li>
          <li><a>Money marbles and chalk</a></li>
          <li><a>Aint nothing but a 'G' thang</a></li>
          <li><a>It´s all about the Benjamins</a></li>
        </ul>
        </div>";
      }
      ?>
    </div>
  </div>
</body>
</html>
