<?php
include '../connection.php';
session_start();
$po_ID = $_SESSION["po_ID"];
$line_item = mysqli_real_escape_string($link, $_POST['line']);

// Find the right lineitem_ID

$lineitemSql = "SELECT lineitem_ID
				FROM lineitem
				WHERE po_ID = '$po_ID'
				AND line_on_po = '$line_item'";
$lineitemResult = mysqli_query($link, $lineitemSql);
while($row = mysqli_fetch_array($lineitemResult)){
	$lineitem_ID = $row[0];
}
// first we delete the tool from the regulartool and the odd tool table
$toolSql = "DELETE FROM regulartool
			WHERE lineitem_ID = '$lineitem_ID'";
$toolResult = mysqli_query($link, $toolSql);

$toolSql = "DELETE FROM oddshapedtool
			WHERE lineitem_ID = '$lineitem_ID'";
$toolResult = mysqli_query($link, $toolSql);
// then we delete the item that has the right line nubmer on the right PO
$sql = "DELETE FROM lineitem 
		WHERE po_ID = '$po_ID'
		AND line_on_po = '$line_item'";
$result = mysqli_query($link, $sql);


//if the query goes wrong
if(!$result){
  echo ("Error deleting, are you sure this PO has no runs connected to it?" . mysqli_error($link));
}
mysqli_close($link);
?>
