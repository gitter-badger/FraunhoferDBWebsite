<?php

include '../connection.php';

$q = mysqli_real_escape_string($link, $_GET['q']);

$_SESSION["po_ID"] = $q;

$sql = "SELECT p.po_number, p.receiving_date, c.customer_name,  p.shipping_date, p.nr_of_lines 
		FROM pos p, customer c
		WHERE p.customer_ID = c.customer_ID
		AND po_ID = '$q'";

$sumdata = "SELECT COUNT(po_ID)
			FROM POTools
			WHERE po_ID = '$POID'";

$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
while($row = mysqli_fetch_array($result)) {
    echo "<p>".'PO number : '          .$row[0]."</p>";
    echo "<p>".'Reciving Date : '      .$row[1]."</p>";
    echo "<p>".'Customer : '           .$row[2]."</p>";
    echo "<p>".'Shipping Date : '      .$row[3]."</p>";
    echo "<p>".'Number of Lines : '    .$row[4]."</p>";
}
mysqli_close($link);
?>






















