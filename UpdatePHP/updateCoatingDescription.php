<?php
include '../connection.php';

$coating_ID   = mysqli_real_escape_string($link, $_POST['coating_ID']);
$coating_description = mysqli_real_escape_string($link, $_POST['coating_description']);

$sql = "UPDATE coating
		SET coating_description = '$coating_description'
		WHERE coating_ID = $coating_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>