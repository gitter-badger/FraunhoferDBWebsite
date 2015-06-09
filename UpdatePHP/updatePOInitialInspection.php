<?php
include '../connection.php';

$po_ID   = mysqli_real_escape_string($link, $_POST['po_ID']);
$initial_inspection   = mysqli_real_escape_string($link, $_POST['initial_inspection']);


$sql = "UPDATE pos
        SET initial_inspection = '$initial_inspection'
        WHERE po_ID = '$po_ID'";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>