<?php

include '../connection.php';

// getting the right POID from the html side
$q = mysqli_real_escape_string($link, $_GET['q']);
// display the table
echo         "<tr>".
"<td>Coating type</td>".
"<td>AH/Pulses</td>".
"<td>runNumber</td>".                
"<td>Run ID</td>".
"<td>Comments</td>".
"</tr>";

// select all the info about the run we need
$sql = "SELECT c.coatingType, r.ah_pulses, r.run_number, r.RID, r.run_comment 
        FROM Runs r, Coatings c
        WHERE POID = '$q' 
        AND r.CoatingID = c.coatingID
        ORDER BY run_number";
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
    echo "<td>".$Row[0]."</td>".
         "<td>".$Row[1]."</td>". 
         "<td>".$Row[2]."</td>".
         "<td>".$Row[3]."</td>".
         "<td>".$Row[4]."</td>".
         "</tr>";
}
?>





















