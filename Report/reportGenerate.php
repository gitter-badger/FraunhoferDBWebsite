<?php
/*
	This file generates the report data from the user input
*/
include '../connection.php';
session_start();

$customer    = mysqli_real_escape_string($link, $_POST['customer_ID']);
$first_date  = mysqli_real_escape_string($link, $_POST['date_from']);
$last_date   = mysqli_real_escape_string($link, $_POST['date_to']);
$date_type   = mysqli_real_escape_string($link, $_POST['date_type']);

//Get customer name from customer_ID
$custSql = "SELECT customer_name FROM customer WHERE customer_ID = '$customer'";
$custResult = mysqli_query($link, $custSql);
while($row = mysqli_fetch_array($custResult)){
	$customer_name = $row[0];
}

/*
	Query that fetches most of the info needed.
	We do not want to include POS that have not been shipped.
	The date type can be MONTH, YEAR or WEEK and the query 
	is grouped by that.
*/
$poSql = "SELECT ".$date_type."(shipping_date), count(p.po_ID), ROUND(AVG(final_price), 2), ROUND(AVG(TOTAL_WEEKDAYS(shipping_date, receiving_date)), 2), ROUND(SUM(p.final_price), 2)
		  FROM pos p, customer c
		  WHERE p.customer_ID = c.customer_ID
		  AND c.customer_ID = '$customer'
		  AND po_ID NOT IN (SELECT po_ID
		  				  	FROM pos
		                    WHERE shipping_date IS NULL)";

if(!empty($first_date)){
	$poSql .= "AND shipping_date >= '$first_date' ";
}
if(!empty($last_date)){
	$poSql .= "AND shipping_date <= '$last_date' ";
}
$poSql .= "GROUP BY ".$date_type." (shipping_date);";
$poResult = mysqli_query($link, $poSql);

if(!$poResult){echo mysqli_error($link);}

/*
	This query fetches info for the lineitems linked to the customer
	Its easier having this in a special query rather than putting it in the big one.
*/
$lineSql = "SELECT SUM(l.quantity)
			FROM lineitem l, pos p
			WHERE l.po_ID = p.po_ID
			AND p.customer_ID = '$customer'
			AND p.po_ID NOT IN (SELECT po_ID
								FROM pos
								WHERE shipping_date IS NULL)
			GROUP BY ".$date_type."(shipping_date);";
$lineResult = mysqli_query($link, $lineSql);

?>
<!-- The header of the output table -->
<div id='output'>
	<h4><?php echo $customer_name;?></h4>
	<table class='table table-striped table-bordered'>
		<tr>
			<th><?php echo $date_type; ?></th>
			<th># of POS</th>
		    <th>Avg PO price</th>
			<th>AVG turn around time</th>
			<th>Number of tools</th>
			<th>Total</th>
			<th>Average tool price</th>
		<tr>
<?php 
/*
	Fill an array with the data from the second query
	This is done so its easy to fetch the data in the While loop that itterates through 
	the big query.
*/
$linearray;
while($line = mysqli_fetch_array($lineResult)){
	$linearray[] .= $line[0];
}
$lineItterate = 0;
while($row = mysqli_fetch_array($poResult)){
	$avgToolPrice = ($row[4] / $linearray[$lineItterate]);
	echo "<tr>";
	echo "<td>".$row[0]."</td>";// month
	echo "<td>".$row[1]."</td>";// # of pos
	echo "<td>$".$row[2]."</td>";// AVG po price
	echo "<td>".$row[3]."</td>";// AVG turn around time
	echo "<td>".$linearray[$lineItterate]."</td>";// Number of tools
	echo "<td>$".$row[4]."</td>";// Total price
	echo "<td>$".round($avgToolPrice, 2)."</td>";// Average tool price
	$lineItterate = $lineItterate + 1;
}
?>
	</table>
</div>