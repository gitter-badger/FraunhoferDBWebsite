<?php
include '../connection.php';
$q = mysqli_real_escape_string($link, $_GET['POID']);
//getting the right po_ID
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$q';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $po_ID = $row[0];
}
$sql = "SELECT l.line_on_po, l.tool_ID, l.quantity
		FROM lineitem l
		WHERE po_ID = '$po_ID';";
$result = mysqli_query($link, $sql);
$colorBool = true;
while($row = mysqli_fetch_array($result)){
	if($colorBool){
		echo "<li class='list-group-item list-group-item-success'>Line# : <em>".$row[0]."</em> ToolID : <em>".$row[1]."</em> Quantity : <em>".$row[2]."</li>";
		$colorBool = !$colorBool;
	}else{
		echo "<li class='list-group-item list-group-item-info'>Line# : <em>".$row[0]."</em> ToolID : <em>".$row[1]."</em> Quantity : <em>".$row[2]."</li>";
		$colorBool = !$colorBool;
	}
}
echo "Do you want to see something more here??";

mysqli_close($link);
?>



















