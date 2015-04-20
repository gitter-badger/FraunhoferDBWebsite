<!-- this file needs to be changed 100% -->
<?php
include '../connection.php';

$po_ID      = mysqli_real_escape_string($link, $_POST['POID']);
$line_item = mysqli_real_escape_string($link, $_POST['line']);

// first we have to find the right po_ID from the po_Number we get from the user
$po_IDsql = "SELECT l.po_ID
             FROM lineitem l, pos p
             WHERE p.po_number = '$po_ID'
             AND l.po_ID = p.po_ID;";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $po_ID = $row[0];
}

// then we delete the item that has the right line nubmer on the right PO
$sql = "DELETE FROM lineitem 
		WHERE po_ID = '$po_ID'
		AND line_on_po = '$line_item'";
$result = mysqli_query($link, $sql);


//if the query goes wrong
if(!$result){
  echo ("Error deleting" . mysqli_error($link));
}
mysqli_close($link);
?>
