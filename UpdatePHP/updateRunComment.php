<?php
/*
	Update the comment for a run
	important so you can add runs before they are finished
*/
include '../connection.php';

$comment = mysqli_real_escape_string($link, $_POST['comment']);
$run_ID  = mysqli_real_escape_string($link, $_POST['run_ID']);

$sql = "UPDATE run 
		SET run_comment = '$comment'
		WHERE run_ID = $run_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>

