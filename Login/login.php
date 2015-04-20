<!DOCTYPE html>
<?php
// Start the session
include '../connection.php';
//session_start();
?>
<html>
<head>
  <script type="text/javascript" src='../js/passScript.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
  <title>Fraunhofer CCD</title>
</head>
<body>
    <h2>Log in using your Employee ID not your full name!</h2>
    <label for='userID'>Employee ID:</label><br>
    <input type='text' name='userID' id='userID'><br>
    <label for='password'>Password:</label><br>
    <input type='password' name='password' id='password'><br>
    <input class='col-md-offset-4' id='loginbtn'type="submit" value="Login" onclick='authenticate()'>
    <p>All our employee ID's</p>
    <div>
    <?php
      $sql = "SELECT employee_name, employee_ID
              FROM employee";
      $result = mysqli_query($link, $sql);
      while($row = mysqli_fetch_array($result)){
        echo "<span>".$row[0]." ID: ".$row[1]."</span></br>";
      }


     ?>
   </div>
    <p id='txtadd' name='txtadd'></p>

    <a href='../selection.php'>Selection page</a>
</body>
<!-- Script to make the input fields behave like a form -->
  <script type='text/javascript'>
  $(document).ready(function(){
    $('#password').keypress(function(e){
      if(e.keyCode==13)
      $('#loginbtn').click();
    });
  });
  </script>
</html>