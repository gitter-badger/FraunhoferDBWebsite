<?php
/*
	This file searches for pos with the data from the user
*/
include '../connection.php';
session_start();

$input       = mysqli_real_escape_string($link, $_POST['po_number']);
$customer_ID = mysqli_real_escape_string($link, $_POST['customer_ID']);
$first_date  = mysqli_real_escape_string($link, $_POST['first_date']);
$last_date   = mysqli_real_escape_string($link, $_POST['last_date']);
// put a wildcard char after the po_number so it displays everything that starts with this string
$stringInput = $input . '%';

$sql = "SELECT po_ID, po_number, customer_ID, receiving_date, nr_of_lines, shipping_date, final_price
	    FROM pos
	    WHERE 1
	    AND po_number LIKE '$stringInput'";
if(!empty($customer_ID))
{
	$sql .= "AND customer_ID = '$customer_ID'";
}
if(!empty($first_date)){
	$sql .= "AND receiving_date > '$first_date'";
}
if(!empty($last_date)){
	$sql .= "AND receiving_date < '$last_date'";
}
$result = mysqli_query($link, $sql);

if(!$result){echo mysqli_error($link);}

echo "<table id='output'>
		<tr>
	  		<th>po ID</th>
      		<th>po number</th>
	        <th>Customer ID</th>
      		<th>Receiving Date</th>
      		<th>Number of lines</th>
  		    <th>Shipping date</th>
      		<th>Final Price</th>
      	<tr>";
while($row = mysqli_fetch_array($result)){
	echo "<tr class='output'>".
			"<td>".$row[0]."</td>".
			"<td>".$row[1]."</td>".
			"<td>".$row[2]."</td>".
			"<td>".$row[3]."</td>".
			"<td>".$row[4]."</td>".
			"<td>".$row[5]."</td>".
			"<td>".$row[6]."</td>".
		  "</tr>";
}

echo "</table";
?>