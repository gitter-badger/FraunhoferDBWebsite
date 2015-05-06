<?php
include '../connection.php';

$employee_ID   = mysqli_real_escape_string($link, $_POST['employee_ID']);
$employee_email = mysqli_real_escape_string($link, $_POST['employee_email']);

$sql = "UPDATE employee
        SET employee_email = '$employee_email'
        WHERE employee_ID = $employee_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>