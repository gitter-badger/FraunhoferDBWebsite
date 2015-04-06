<?php
include 'connection.php';
phpinfo();
// Escape user inputs for security
$username = mysqli_real_escape_string($link, $_GET['username']);
$password = mysqli_real_escape_string($link, $_GET['password']);
var_dump($username);

/*
*
*
*
TODO : HASH THE PASSWORDS!!!
*
*
*/
$sql = "SELECT ename
		FROM Employees
		WHERE ename = '$username'
		AND pass = '$password'";
$result = mysqli_query($link, $sql);
echo "rass";
if(empty($result)){
	echo "<div><p>"."Query was empty"."</p></div>";
}else{
	echo "<div><p>"."Query was not empty"."</p></div>";
}




$_SESSION["username"] = "";
$_SESSION["password"] = "cat";


 
// close connection
mysqli_close($link);
?>




