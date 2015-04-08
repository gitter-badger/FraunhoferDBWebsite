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
    <label for='user'>Username:</label><br>
    <input type='text' name='user' id='user'><br>
    <label for='password'>Password:</label><br>
    <input type='password' name='password' id='password'><br>
    <input class='col-md-offset-4' type="submit" value="Login" onclick='authenticate()'>
    <p id='txtadd' name='txtadd'></p>

    <a href='../selection.php'>Selection page</a>
</body>
</html>