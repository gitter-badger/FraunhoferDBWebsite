<?php
include '../connection.php';

$coating_ID   = mysqli_real_escape_string($link, $_POST['coating_ID']);
$coating_type = mysqli_real_escape_string($link, $_POST['coating_type']);

$sql = "UPDATE coating
		SET coating_type = '$coating_type'
		WHERE coating_ID = $coating_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>