<?php

include '../connection.php';


$q = mysqli_real_escape_string($link, $_GET['q']);

$sql = "SELECT l.line_on_po, lr.number_of_items_in_run, r.run_number, lr.lineitem_run_comment 
        FROM lineitem l, lineitem_runs lr, runs r
        WHERE l.po_ID = '$q'
        AND l.lineitem_ID = lr.lineitem_ID
        AND lr.run_ID = r.run_ID;";

$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
   echo         "<tr>".
                "<td>Line Item#</td>".
                "<td>Number of Tools</td>".                
                "<td>Run number</td>".
                "<td>Final Comment</td>".
                "</tr>";

while($row = mysqli_fetch_array($result)) {
   echo 
        "<tr>".
        "<td>".$row[0]."</td>".
        "<td>".$row[1]."</td>".
        "<td>".$row[2]."</td>".
        "<td>".$row[3]."</td>".
        "</tr>";
}

?>





















