<?php
include '../connection.php';

$po_ID   = mysqli_real_escape_string($link, $_POST['po_ID']);
$receiving_date   = mysqli_real_escape_string($link, $_POST['receiving_date']);


$sql = "UPDATE pos
        SET receiving_date = '$receiving_date'
        WHERE po_ID = '$po_ID'";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>