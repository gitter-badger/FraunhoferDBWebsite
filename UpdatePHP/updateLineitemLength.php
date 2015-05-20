<?php
include '../connection.php';

$po_ID 	   = mysqli_real_escape_string($link, $_POST['po_ID']);
$line  	   = mysqli_real_escape_string($link, $_POST['line']);
$length  = mysqli_real_escape_string($link, $_POST['length']);

$sql = "UPDATE lineitem
        SET length = '$length'
        WHERE po_ID = $po_ID
        AND line_on_po = '$line'";   
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Error: ' . mysql_error();
    die($message);
}
mysqli_close($link);
?>