<?php
include '../connection.php';

$po_ID   = mysqli_real_escape_string($link, $_POST['po_ID']);
$number_of_lines   = mysqli_real_escape_string($link, $_POST['number_of_lines']);


$sql = "UPDATE pos
        SET nr_of_lines = '$number_of_lines'
        WHERE po_ID = '$po_ID'";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>