<?php
include '../connection.php';

$employee_ID   = mysqli_real_escape_string($link, $_POST['employee_ID']);
$employee_name = mysqli_real_escape_string($link, $_POST['employee_name']);

$sql = "UPDATE employee
        SET employee_name = '$employee_name'
        WHERE employee_ID = $employee_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>