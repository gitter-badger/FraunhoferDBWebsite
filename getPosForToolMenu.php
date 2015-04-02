<?php

include 'connection.php';

$q = mysqli_real_escape_string($link, $_GET['q']);

$sql = "SELECT p.POID, p.receiving_date, c.cName,  p.shipping_date, p.nr_of_lines 
FROM POS p, Customers c
WHERE p.CID = c.CID
AND POID = '$q'";
$sumdata = "SELECT COUNT(POID)
FROM POTools
WHERE POID = '$POID'";

$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
while($row = mysqli_fetch_array($result)) {
    $POID = $row[0];
    echo "<p class ='col-md-1'>".'POID:'."<div type='hidden' id='POID'>".$POID."</div>"."</p>";
    echo "<p>".'Reciving Date :    ' . $row[1] ."</p>";
    echo "<p>".'Customer :    ' .$row[2] ."</p>";
    echo "<p>". 'Shipping Date :    ' . $row[3] ."</p>";
    echo "<p>". 'Number of Lines :    ' . $row[4] ."</p>";
}
mysqli_close($link);
?>






















