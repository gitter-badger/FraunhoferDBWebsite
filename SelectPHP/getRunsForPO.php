<?php

include '../connection.php';

// getting the right POID from the html side
$q = mysqli_real_escape_string($link, $_GET['q']);
$po_IDsql = "SELECT p.po_ID
             FROM pos p
             WHERE p.po_number = '$q';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $POID = $row[0];
}
// display the table
echo         "<tr>".
"<td>Coating type</td>".
"<td>AH/Pulses</td>".
"<td>runNumber</td>".                
"<td>Run ID</td>".
"<td>Comments</td>".
"</tr>";

// select all the info about the run we need
$sql = "SELECT c.coating_type, r.ah_pulses, posr.run_number_on_po, r.run_number, r.run_comment 
        FROM run r, pos_run posr, coating c
        WHERE r.run_ID = posr.run_ID
        AND posr.po_ID = '$POID'
        AND r.coating_ID = c.coating_ID
        ORDER BY posr.run_number_on_po";
//run a query to find the right ID of our coating
$result = mysqli_query($link, $sql);


if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

//first we get the coating type 
//from the coatingResult query
//then we get the rest of the data
while($row = mysqli_fetch_array($result)){
    echo "<td>".$row[0]."</td>".
         "<td>".$row[1]."</td>". 
         "<td>".$row[2]."</td>".
         "<td>".$row[3]."</td>".
         "<td>".$row[4]."</td>".
         "</tr>";
}
?>





















