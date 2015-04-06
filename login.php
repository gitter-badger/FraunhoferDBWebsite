<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<?php
include 'connection.php';
?>
<html>
<head>
  <title>Fraunhofer CCD</title>
</head>
<body>
  <form action='authenticator.php'>
    <label for='user'>Username:</label><br>
    <input type='text' name='user' id='user'><br>
    <label for='password'>Password:</label><br>
    <input type='password' name='password' id='password'><br>
    <input class='col-md-offset-4' type="submit" id="btn_submit" value="Login">
  </form>
</body>
</html>

