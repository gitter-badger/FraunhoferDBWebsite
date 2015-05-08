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
        <h2>Dont use your real password!!!!!</h2>
        <p>This is the add new Employee view</p>

        <form onsubmit='return false'>
          <p class='col-md-6'>
            <label for="eName">Employee name: </label>
            <input type="text" name="eName" id="eName">
          </p>
          <p class='col-md-6'>
            <label for="sec_lvl">Security level 1-4: </label>
            <input type="text" name="sec_lvl" id="sec_lvl">
          </p>
          <p class='col-md-6'>
            <label for="ePhoneNumber">Phone Number: </label>
            <input type="text" name="ePhoneNumber" id="ePhoneNumber">
          </p>
          <p class='col-md-6'>
            <label for="eEmail">Employee Email: </label>
            <input type="rDate" name='eEmail' id='eEmail'>
          </p>
          <p class='col-md-6'>
            <label for="ePass">Password: </label>
            <input type="password" name="ePass" id="ePass">
          </p>
          <p class='col-md-6'>
            <label for="ePassAgain">Confirm Password:</label>
            <input type="password" name="ePassAgain" id="ePassAgain" onkeyup="checkPass(); return false;">
            <span id="confirmMessage" class="confirmMessage"></span>
          </p>
          <input class='col-md-offset-1'type="submit" value="Add Employee to Database" onclick='addEmployee()'>
        </form>
      </div>
    </div>
  </div>


</body>
</html>


