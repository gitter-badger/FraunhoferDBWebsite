<?php
include '../connection.php';

$po_ID 	   = mysqli_real_escape_string($link, $_POST['po_ID']);
$line  	   = mysqli_real_escape_string($link, $_POST['line']);
$tool_ID  = mysqli_real_escape_string($link, $_POST['tool']);

$sql = "UPDATE lineitem
        SET tool_ID = '$tool_ID'
        WHERE po_ID = '$po_ID'
        AND line_on_po = '$line'";   
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Error: ' . mysql_error();
    die($message);
}
var_dump($tool_ID);
mysqli_close($link);
?>