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
        <p>Add new coating to the database</p>
        <p class='col-md-6'>
          <label for="coatingType">Coating type</label>
          <input type="text" name="coatingType" id="coatingType">
          Fx. AlTin
        </p>
        <p class='col-md-6'>
          <label for="coatingDesc">Coating Description</label>
          <input type="text" name="coatingDesc" id="coatingDesc">
          Fx. 60% Aluminum 40% titanium
        </p>
        <input class='col-md-offset-1'type="button" value="Add coating to database" onclick='addCoating()'>
      </div>
    </div>
    <div>
      <p id='errormsg'></p>
    </div>
  </div>
</body>
</html>