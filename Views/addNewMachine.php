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
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <script src='../js/bootstrap.min.js'></script>
</head>
<body>
<?php include '../header.php'; ?>
    <div class='container'>
      <div class='row well well-lg'>
        <div class='col-md-12'>
          <p>This is the add new machine View</p>
            <p class='col-md-6'>
              <label for="mname">Machine Name: </label>
              <input type="text" name="mname" id="mname">
            </p>
            <p class='col-md-6'>
              <label for="macro">Short Version(acronym): </label>
              <input type="text" name='macro' id='macro'>
            </p>
            <input class='col-md-offset-1'type="button" value="Add Machine to Database" onclick='addNewMachine()'>
        </div>
      </div>
      <div>
      <p id='errormsg'></p>
    </div>
    </div>


  </body>
  </html>


