<?php
include '../connection.php';
$po_ID      = mysqli_real_escape_string($link, $_POST['POID']);
$tool_ID    = mysqli_real_escape_string($link, $_POST['toolID']);
$quantity  = mysqli_real_escape_string($link, $_POST['quantity']);
$line_item = mysqli_real_escape_string($link, $_POST['lineItem']);
$diameter  = mysqli_real_escape_string($link, $_POST['diameter']);
$length    = mysqli_real_escape_string($link, $_POST['length']);
$price     = mysqli_real_escape_string($link, $_POST['price']);
$doubleEnd = mysqli_real_escape_string($link, $_POST['dblEnd']);
var_dump($po_ID);
if($doubleEnd == 'on'){
	$doubleEnd = 1;
	$price = $price * 2;
}
#convert diameter to string so MySQL doesnt read it as a number.
//$diameter = (string)$diameter;
//find the right po_ID to insert into the lineitem table
$rightpo_IDsql = "SELECT po_ID FROM pos WHERE po_number = '$po_ID'";
$po_IDresult = mysqli_query($link, $rightpo_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
	$rightPO = $row[0];
}
//var_dump($rightPO);


$sql = "INSERT INTO lineitem(line_on_po, po_ID, quantity, tool_ID, diameter, length, double_end, price) VALUES('$line_item', '$rightPO', '$quantity', '$tool_ID', '$diameter', '$length', '$doubleEnd', '$price')";

$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Invalid result query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole result query: ' . $query;
    die($message);
}
mysqli_close($link);
?>
