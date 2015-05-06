<?php
include '../connection.php';

$employee_ID   = mysqli_real_escape_string($link, $_POST['employee_ID']);
$security_level = mysqli_real_escape_string($link, $_POST['security_level']);

$sql = "UPDATE employee
        SET security_level = '$security_level'
        WHERE employee_ID = '$employee_ID'";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>