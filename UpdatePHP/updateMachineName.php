<?php
include '../connection.php';

$machine_ID   = mysqli_real_escape_string($link, $_POST['machine_ID']);
$machine_name = mysqli_real_escape_string($link, $_POST['machine_name']);

$sql = "UPDATE machine
		SET machine_name = '$machine_name'
		WHERE machine_ID = $machine_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>