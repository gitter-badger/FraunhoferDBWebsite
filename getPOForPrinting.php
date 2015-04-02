<?php

include 'connection.php';

$q = mysqli_real_escape_string($link, $_GET['q']);

$sql = "SELECT p.POID, p.receiving_date, c.cName,  p.shipping_date, p.nr_of_lines 
FROM POS p, Customers c
WHERE p.CID = c.CID
AND POID = '$q'";

$result = mysqli_query($link, $sql);

$tsql = "SELECT pot.line_item, pot.quantity, pot.TID, t.tDiameter, t.tLength, t.tPrice, SUM(ROUND(t.tPrice * pot.quantity, 2)) 
FROM POTools pot, Tools t, POS p
WHERE pot.POID = '$q'
AND pot.POID = p.POID
AND p.CID = t.CID
AND t.TID = pot.TID
GROUP BY pot.line_item";
$tresult = mysqli_query($link, $tsql);

$sumSql = "SELECT SUM(quantity)
FROM POTools
WHERE POID = '$q'";
$sumresult = mysqli_query($link, $sumSql);


while($row = mysqli_fetch_array($result)) {
    $POID = $row[0];
    echo "<p>".'Reciving Date :    ' . $row[1] ."</p>";
    echo "<p>".'Customer :    ' .$row[2] ."</p>";
    echo "<p>". 'Shipping Date :    ' . $row[3] ."</p>";
    echo "<p>". 'Number of Lines :    ' . $row[4] ."</p>";
}

echo "<table>";
echo         "<tr>".
"<td>Line#</td>".
"<td>Quantity</td>".  
"<td>ToolID</td>".
"<td>diameter</td>".
"<td>length</td>".
"<td>double end</td>".
"<td>unit price</td>".
"<td>total unit price</td>".
"</tr>";
                //filling it with data from POTools

while($row = mysqli_fetch_array($tresult)) {
 echo
 "<tr>".
 "<td>".$row[0]."</td>".
 "<td>".$row[1]."</td>".
 "<td>".$row[2]."</td>".
 "<td>".$row[3]."</td>".
 "<td>".$row[4]."</td>".
 "<td>No</td>".
 "<td>".$row[5]."</td>".
 "<td>".$row[6]."</td>".
 "</tr>";
}
$totalPricesql = "SELECT SUM(ROUND(t.tPrice * pot.quantity, 2)) 
FROM POTools pot, Tools t, POS p
WHERE p.POID = '$q'
AND pot.POID = p.POID
AND pot.TID = t.TID
AND t.CID = p.CID";

$totalPriceResult = mysqli_query($link, $totalPricesql);

while($row = mysqli_fetch_array($sumresult)){
    echo "<tr>".
    "<td>Total: </td>".
    "<td>".$row[0]."</td>".
    "<td></td>".
    "<td></td>".
    "<td></td>".
    "<td></td>";
}
while($frow = mysqli_fetch_array($totalPriceResult)){
    echo "<td>Total price:</td>".
    "<td>$".$frow[0]."</td>".
    "</tr>";
}


mysqli_close($link);
?>
