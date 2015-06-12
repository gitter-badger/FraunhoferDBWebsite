<?php
include '../connection.php';
// Escape user inputs for security
session_start();

$po_number = $_SESSION["po_ID"];
$date 	   = mysqli_real_escape_string($link, $_POST['date']);
// if the date is empty we dont insert it to the DB


if($date == ""){ 
	echo "Error. Empty date";
}
else{
// the following code is to check if we have coated all the tools. The user
// decides if he wants to continue if there are missing tools

$quantitySql = "SELECT SUM(quantity) 
				FROM lineitem 
				WHERE po_ID = '$po_number';";
$quantityResult = mysqli_query($link, $quantitySql);

$coatedToolsSql = "SELECT SUM(number_of_items_in_run)
				   FROM lineitem_run lr, lineitem l 
				   WHERE l.po_ID = '$po_number'
				   AND l.lineitem_ID = lr.lineitem_ID;";
$coatedToolResult = mysqli_query($link, $coatedToolsSql);

while($row = mysqli_fetch_array($quantityResult)){
	$quantity = $row[0];
}
while($row = mysqli_fetch_array($coatedToolResult)){
	$coatedToolSum = $row[0];
}
if($quantity > $coatedToolSum){
	$missing = $quantity - $coatedToolSum;
	echo "You havent assigned all tools to runs. You are missing : ".$missing." tools. If you want to continue anyway press OK"; 
}
if($quantity < $coatedToolSum){
	$missing = $coatedToolSum - $quantity;
	echo "You have assigned more tools to runs then you got! You assigned : ".$missing." extra tools. If you want to continue anyway press OK"; 
}


mysqli_close($link);
}
?>
