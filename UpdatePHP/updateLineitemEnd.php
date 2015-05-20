<?php
include '../connection.php';

$po_ID = mysqli_real_escape_string($link, $_POST['po_ID']);
$line  = mysqli_real_escape_string($link, $_POST['line']);
$end   = mysqli_real_escape_string($link, $_POST['end']);

if($end == '0' || $end == '1'){

$sql = "UPDATE lineitem
        SET double_end = '$end'
        WHERE po_ID = $po_ID
        AND line_on_po = '$line'";   
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Error: ' . mysql_error();
    die($message);
}
}
else {
	die("Error. Value must be either 1 or 0");
}
mysqli_close($link);
?>