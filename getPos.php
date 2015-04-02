<?php
include 'connection.php';
$q = intval($_GET['q']);

$sql = "SELECT p.POID, c.cName, p.receiving_date, p.initial_inspection, p.final_inspection, p.nr_of_lines, p.shipping_date 
        FROM POS p, Customers c 
        WHERE p.CID = c.CID 
        AND c.CID = '$q'
        ORDER BY p.receiving_date";
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

echo "<table id='report'>
      <tr>
      <th>POID</th>
      <th>Customer</th>
      <th>Receiving Date</th>
      <th>Initial Inspection</th>
      <th>Final Inspection</th>
      <th>Number of Lines</th>
      <th>Shipping Date</th>
      </tr>";

while($row = mysqli_fetch_array($result)) {
    $rightRow = $row[0];
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "<td>" . $row[2] . "</td>";
    echo "<td>" . $row[3] . "</td>";
    echo "<td>" . $row[4] . "</td>";
    echo "<td>" . $row[5] . "</td>";
    echo "<td>" . $row[6] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
