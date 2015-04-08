<?php

include '../connection.php';

$POID  = mysqli_real_escape_string($link, $_POST['POID']);
$diameter  = mysqli_real_escape_string($link, $_POST['diameter']);
$length = mysqli_real_escape_string($link, $_POST['length']);




$sql ="SELECT DISTINCT p.price
	   FROM Prices p, POS po
	   WHERE po.POID = '$POID'
	   AND po.CID = p.CID
	   AND p.diameter = '$diameter'
	   AND p.length = '$length'";

$rightPrice = mysqli_query($link, $sql);
while($row = mysqli_fetch_array($rightPrice)){
	$price = $row[0];
}
echo "  
		<div>
        <label for='price'>Unit Price: </label>
        <input type='number' name='price' id='price' value='".$price."'>
        </div>";
mysqli_close($link);
?>

