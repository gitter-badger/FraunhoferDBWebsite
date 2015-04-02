<?php

include 'connection.php';


$q = mysqli_real_escape_string($link, $_GET['q']);

$sql = "SELECT rpo.line_item, rpo.number_of_items, r.run_number, rpo.final_comment 
        FROM RunPOS rpo, Runs r
        WHERE rpo.POID = r.POID
        AND rpo.RID = r.RID
        AND rpo.POID = '$q'
        GROUP BY rpo.RPOID;";

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





















