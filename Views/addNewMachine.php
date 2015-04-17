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


