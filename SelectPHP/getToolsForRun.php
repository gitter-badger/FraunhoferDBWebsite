<?php

include '../connection.php';


$q = mysqli_real_escape_string($link, $_GET['q']);
//  Find the right po_id from the po_number from the user
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$q';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $POID = $row[0];
}
$sql = "SELECT l.line_on_po, lr.number_of_items_in_run, r.run_number, lr.lineitem_run_comment 
        FROM lineitem l, lineitem_run lr, run r
        WHERE l.po_ID = '$POID'
        AND l.lineitem_ID = lr.lineitem_ID
        AND lr.run_ID = r.run_ID
        ORDER BY l.line_on_po;";

$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

echo"<tr>".
    "<td>Line Item#</td>".
    "<td>Number of Tools</td>".                
    "<td>Run number</td>".
    "<td>Final Comment</td>".
    "</tr>";

while($row = mysqli_fetch_array($result)) {
   echo "<tr>".
        "<td>".$row[0]."</td>".
        "<td>".$row[1]."</td>".
        "<td>".$row[2]."</td>".
        "<td>".$row[3]."</td>".
        "</tr>";
}

?>





















