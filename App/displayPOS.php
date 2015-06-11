<?php
include '../connection.php';

$sql = "SELECT po_ID, po_number
		FROM pos
		WHERE po_ID = 50;";
$result = mysqli_query($link, $sql);

while($row = mysqli_fetch_array($result)){
	$po_ID = $row[0];
	$po_number = $row[1];
}
echo "Po_ID : ".$po_ID." Po_number : " .$po_number;
?>