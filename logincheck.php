<?php
include 'connection.php';
session_start();

// Escape user inputs for security
$username = mysqli_real_escape_string($link, $_POST['username']);
$password = mysqli_real_escape_string($link, $_POST['password']);
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

$rowCount = mysqli_num_rows($result);

if($rowCount == 0){
	echo "<div><p>"."No results from this query"."</p></div>";
	session_unset(); 
	session_destroy(); 
	die("Wrong info!".mysqli_error($link));
}else{
	echo "<div><p>"."User found with this info"."</p></div>";

$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
}

$usersql = "SELECT * 
			FROM Employees
			WHERE ename = '$username'";
$userResult = mysqli_query($link, $usersql);

while($row = mysqli_fetch_array($userResult)){
	echo "ID: ".$row[0]."<br>".
		 "Pass: ".$row[1]."<br>".
		 "Username: ".$row[2]."<br>".
		 "Email: ".$row[3]."<br>".
		 "PhoneNumber: ".$row[4]."<br>";
}
echo "Session username is : " . $_SESSION["username"]. "</br>";



// close connection
mysqli_close($link);
?>




