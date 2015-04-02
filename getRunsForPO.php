<?php

include 'connection.php';


$q = mysqli_real_escape_string($link, $_GET['q']);

$sql = "SELECT coating_type, ah_pulses, run_number, RID, run_comment FROM Runs WHERE POID = '$q' ORDER BY run_number";

$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
echo         "<tr>".
"<td>Coating type</td>".
"<td>AH/Pulses</td>".
"<td>runNumber</td>".                
"<td>Run ID</td>".
"<td>Comments</td>".
"</tr>";

while($row = mysqli_fetch_array($result)) {
    echo 
    "<tr>".
    "<td>".$row[0]."</td>".
    "<td>".$row[1]."</td>".
    "<td>".$row[2]."</td>".
    "<td>".$row[3]."</td>".
    "<td>".$row[4]."</td>".
    "</tr>";
}

?>





















