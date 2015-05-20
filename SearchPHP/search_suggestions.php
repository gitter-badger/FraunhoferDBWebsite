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

// build the basic sql statement
$sql = "SELECT p.po_ID, po_number, c.customer_name, receiving_date, SUM(l.quantity), shipping_date, final_price
	    FROM pos p, lineitem l, customer c
	    WHERE 1
	    AND p.po_number LIKE '$stringInput'
	    AND p.po_ID = l.po_ID 
	    AND c.customer_ID = p.customer_ID ";

// if the user has picked some customer_ID it adds that to the query. Same with all the following If statements.
if(!empty($customer_ID))
{
	$sql .= "AND p.customer_ID = '$customer_ID' ";
}
if(!empty($first_date)){
	$sql .= "AND receiving_date > '$first_date' ";
}
if(!empty($last_date)){
	$sql .= "AND receiving_date < '$last_date' ";
}
$sql .= "GROUP BY p.po_ID ";
$sql .= "ORDER BY p.receiving_date DESC;";
$result = mysqli_query($link, $sql);

if(!$result){echo mysqli_error($link);}


echo "<table id='output' class='table table-striped table-bordered'>
		<tr>
      		<th>PO number</th>
	        <th>Customer</th>
      		<th>Receiving Date</th>
      		<th>Number of tools</th>
  		    <th>Shipping date</th>
      		<th>Final Price</th>
      	<tr>";
/*
*	This while loops generates buttons on each line in the table
*	And a modal page for every PO number
*	The Modals are displayed when the user clicks the button
*/
while($row = mysqli_fetch_array($result)){
	echo "<tr class='output'>".
			"<td><a href='#' data-toggle='modal' onclick='setSessionID(".$row[0].")' data-target='#".$row[0]."'>".$row[1]."</td>".
			"<td>".$row[2]."</td>".
			"<td>".$row[3]."</td>".
			"<td>".$row[4]."</td>".
			"<td>".$row[5]."</td>".
			"<td>$".$row[6]."</td>".
		  "</tr>";

	echo "<div class='modal fade' id='".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='".$row[0]."' aria-hidden='true'>
			  <div class='modal-dialog'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			        <h4 class='modal-title' id='myModalLabel'>PO number : ".$row[1]."</h4>
			      </div>
			      <div class='modal-body'>
			        <h3>PO information.<h3>
			        <a class='btn btn-primary' href='../Printouts/tracksheet.php'>Tracksheet</a>
			        <a class='btn btn-primary' href='../Printouts/generalinfo.php'>General info</a>
			        <a class='btn btn-primary' href='../Printouts/packingList.php'>Packing list</a>
			        <a class='btn btn-primary' href='../Views/editPO.php'>Edit this PO</a>
			      </div>
			      <div class='modal-footer'>
			        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			      </div>
			    </div>
			  </div>
		   </div>";
}
echo "</table";
?>