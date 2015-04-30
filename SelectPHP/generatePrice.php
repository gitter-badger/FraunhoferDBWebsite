<?php
/*
	This file generates the price of a tool
	using its length, diameter and customer_ID
	and displays it in the price field.
	If it is a odd tool or the price doesnt exist you can
	still put the price in manually.
*/

include '../connection.php';

$POID      = mysqli_real_escape_string($link, $_POST['POID']);
$diameter  = mysqli_real_escape_string($link, $_POST['diameter']);
$length	   = mysqli_real_escape_string($link, $_POST['length']);




$sql ="SELECT DISTINCT p.amount
	   FROM price p, pos po
	   WHERE po.po_number = '$POID'
	   AND po.customer_ID = p.customer_ID
	   AND p.diameter = '$diameter'
	   AND p.length = '$length'";

$rightPrice = mysqli_query($link, $sql);
if(!$rightPrice){
	mysqli_error($link);
}
while($row = mysqli_fetch_array($rightPrice)){
	$price = $row[0];
}
/*
echo "<div>
      <label for='price'>Unit Price: </label>
      <input type='number' name='price' id='price' value='".$price."'>
      </div>";
*/
$_SESSION['toolprice'] = $price;

echo $_SESSION['toolprice'];
mysqli_close($link);
?>

