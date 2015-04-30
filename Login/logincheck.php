<?php
include '../connection.php';
session_start();

// Escape user inputs for security
$userID = mysqli_real_escape_string($link, $_POST['userID']);
$password = mysqli_real_escape_string($link, $_POST['password']);

// select the username and hashed password
$sql = "SELECT employee_name, employee_password
		FROM employee
		WHERE employee_ID = '$userID'";
//run the query
$result = mysqli_query($link, $sql);
//store the hashed password and Username
while($row = mysqli_fetch_array($result)){
	$username = $row[0];
	$hashedPass = $row[1];
}

if(crypt($password, $hashedPass) == $hashedPass){
	echo "success";
	$_SESSION["username"] = $username;
	
	//This is code to let the user know he is logged in.
	//This is handy while developing but should probably be removed
	$usersql = "SELECT employee_ID, employee_name, employee_email, employee_phone  
				FROM employee
				WHERE employee_ID = '$userID'";
	$userResult = mysqli_query($link, $usersql);
	
	while($row = mysqli_fetch_array($userResult))
	{
		echo "ID: ".$row[0]."<br>".
			 "Username: ".$row[1]."<br>".
			 "Email: ".$row[2]."<br>".
			 "PhoneNumber: ".$row[3]."<br>";
	}
}else
{
	echo "error";
	session_unset(); 
	session_destroy(); 
}


// close connection
mysqli_close($link);
?>



