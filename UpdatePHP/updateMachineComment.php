<?php
include '../connection.php';

$machine_ID      = mysqli_real_escape_string($link, $_POST['machine_ID']);
$machine_comment = mysqli_real_escape_string($link, $_POST['machine_comment']);

$sql = "UPDATE machine
		SET machine_comment = '$machine_comment'
		WHERE machine_ID = $machine_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>