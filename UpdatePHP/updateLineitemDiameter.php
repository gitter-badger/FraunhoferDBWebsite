<?php
include '../connection.php';

$po_ID 	   = mysqli_real_escape_string($link, $_POST['po_ID']);
$line  	   = mysqli_real_escape_string($link, $_POST['line']);
$diameter  = mysqli_real_escape_string($link, $_POST['diameter']);

$sql = "UPDATE lineitem
        SET diameter = '$diameter'
        WHERE po_ID = $po_ID
        AND line_on_po = '$line'";   
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Error: ' . mysql_error();
    die($message);
}
mysqli_close($link);
?>