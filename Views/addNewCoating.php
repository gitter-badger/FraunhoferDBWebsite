<!DOCTYPE html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT sec_lvl
           FROM Employees
           WHERE ename = '$user'";
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
  <div class='navbar navbar-default navbar-static-top'>
    <div class='container'>
      <a href='../selection.php' class='navbar-brand'>Selection Page</a>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='../Login/login.php'>Log in or change user</a></li>
        <li style='margin-top:15px'><strong><?php echo $_SESSION["username"];?></strong></li>
        <li><button onclick='logout()' class='btn btn-danger' style='margin-top:10px'>Logout</button></li>      </ul>
      </div>
    </div>
    <div class='container'>
      <div class='row well well-lg'>
        <div class='col-md-12'>
          <p>Add new coating to the database</p>
              <p class='col-md-6'>
                <label for="coatingType">Coating type</label>
                <input type="text" name="coatingType" id="coatingType">
              </p>
              <p class='col-md-6'>
                <label for="coatingDesc">Coating Description</label>
                <input type="text" name="coatingDesc" id="coatingDesc">
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