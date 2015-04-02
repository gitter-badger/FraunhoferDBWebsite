<?php
include 'connection.php';
$poid      = mysqli_real_escape_string($link, $_POST['POID']);
$toolID    = mysqli_real_escape_string($link, $_POST['toolID']);
$quantity  = mysqli_real_escape_string($link, $_POST['quantity']);
$line_item = mysqli_real_escape_string($link, $_POST['lineItem']);
$diameter  = mysqli_real_escape_string($link, $_POST['diameter']);
$length    = mysqli_real_escape_string($link, $_POST['length']);
$price     = mysqli_real_escape_string($link, $_POST['price']);
$doubleEnd = mysqli_real_escape_string($link, $_POST['dblEnd']);

if($doubleEnd == 'on'){
	$doubleEnd = 1;
	$price = $price * 2;
}
#convert diameter to string so MySQL doesnt read it as a number.
$diameter = (string)$diameter;

#fetch right CID

$cidsql = "SELECT DISTINCT c.CID
		   FROM Customers c, POS p
		   WHERE c.CID = p.cid
		   AND p.POID = '$poid'";

$cidResult = mysqli_query($link, $cidsql);

while($row = mysqli_fetch_array($cidResult)){
	$rightCid = $row[0];
}
if (!$cidResult) {
    $message  = 'Invalid cid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole cid query: ' . $query;
    die($message);
}

#insert Tool into tools table...if it does exist nothing happens. 
$toolsql = "INSERT INTO Tools (TID, CID, tDiameter, tLength, tPrice, double_end) VALUES('$toolID', '$rightCid', '$diameter', '$length', '$price', '$doubleEnd') ON DUPLICATE KEY UPDATE    
tDiameter=VALUES(tDiameter), tLength=VALUES(tLength), tPrice=VALUES(tPrice)";
$toolResult = mysqli_query($link, $toolsql);

$sql = "INSERT INTO POTools(POID, TID, line_item, quantity) VALUES('$poid', '$toolID', '$line_item', '$quantity')";

$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Invalid result query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole result query: ' . $query;
    die($message);
}
mysqli_close($link);
?>
