<?php
/*
	This file inserts a new lineitem and links it to a PO
*/
include '../connection.php';
session_start();
$po_ID = $_SESSION["po_ID"];
//$po_ID     = mysqli_real_escape_string($link, $_POST['POID']);
$tool_ID    = mysqli_real_escape_string($link, $_POST['toolID']);
$quantity   = mysqli_real_escape_string($link, $_POST['quantity']);
$line_item  = mysqli_real_escape_string($link, $_POST['lineItem']);
$diameter   = mysqli_real_escape_string($link, $_POST['diameter']);
$length     = mysqli_real_escape_string($link, $_POST['length']);
$price      = mysqli_real_escape_string($link, $_POST['price']);
$doubleEnd  = mysqli_real_escape_string($link, $_POST['dblEnd']);
$coating_ID = mysqli_real_escape_string($link, $_POST['coating_ID']);


if($doubleEnd == 'on'){
	$doubleEnd = 1;
	$price = $price * 2;
}
// convert diameter to string so MySQL doesnt read it as a number.
// $diameter = (string)$diameter;

/*
	this calculates the est_run_time depending on size and quantity
*/
if($diameter == "1/8"){
	$est_run_number = $quantity * 0.33;
	$est_run_number = $est_run_number / 159;
}

if($diameter == "3/16" || $diameter == "1/4"){
	$est_run_number = $quantity * 0.5;
	$est_run_number = $est_run_number / 159;
}

if($diameter == "3/8" || $diameter == "1/2"){
	$est_run_number = $quantity * 1;
	$est_run_number = $est_run_number / 159;
}

if($diameter == "5/8" || $diameter == "3/4"){
	$est_run_number = $quantity * 2;
	$est_run_number = $est_run_number / 159;
}

if($diameter == "1" || $diameter == "1 1/4" || $diameter == "1 3/8"){
	$est_run_number = $quantity * 3;
	$est_run_number = $est_run_number / 159;
}
$sql = "INSERT INTO lineitem(line_on_po, po_ID, quantity, tool_ID, diameter, length, double_end, price, coating_ID, est_run_number) VALUES('$line_item', '$po_ID', '$quantity', '$tool_ID', '$diameter', '$length', '$doubleEnd', '$price', '$coating_ID', '$est_run_number')";

$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Invalid result query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole result query: ' . $query;
    die($message);
}
mysqli_close($link);
?>
