<?php
include '../connection.php';

$employee_ID   = mysqli_real_escape_string($link, $_POST['employee_ID']);
$employee_phone = mysqli_real_escape_string($link, $_POST['employee_phone']);

$sql = "UPDATE employee
        SET employee_phone = '$employee_phone'
        WHERE employee_ID = $employee_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>