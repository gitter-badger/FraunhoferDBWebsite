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
echo "<tr>".
        "<td>Run ID</td>".
        "<td>Coating type</td>".
        "<td>AH/Pulses</td>".
        "<td>runNumber</td>".                
        "<td>Comments</td>".
     "</tr>";

// select all the info about the run we need
$sql = "SELECT r.run_ID, r.run_number, c.coating_type, r.ah_pulses, posr.run_number_on_po, r.run_comment 
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
    if($row[2] == 1){ $row[2] = a;}
    if($row[2] == 2){ $row[2] = b;}
    if($row[2] == 3){ $row[2] = c;}
    if($row[2] == 4){ $row[2] = d;}
    if($row[2] == 5){ $row[2] = e;}
    if($row[2] == 6){ $row[2] = f;}
    if($row[2] == 7){ $row[2] = g;}
    echo "<td><a href='#' data-toggle='modal' data-target='#".$row[0]."'>".$row[1]."</td>".
         "<td>".$row[2]."</td>". 
         "<td>".$row[3]."</td>".
         "<td>".$row[4]."</td>".
         "<td>".$row[5]."</td>".
         "</tr>";

    echo "<div class='modal fade' id='".$row[0]."' tabindex='-1' role='dialog' aria-labelledby='".$row[0]."' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>Run number : ".$row[1]."</h4>
                  </div>
                  <div class='modal-body'>
                    <h3>Add or edit run comment</h3>
                    <p>This is the current comment</p>
                    <textarea id='new_comment'>".$row[5]."</textarea>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-default' onclick='showPOTools()' data-dismiss='modal'>Close</button>
                    <button type='button' class='btn btn-success' onclick='updateRunComment(".$row[0].")'>Save changes</button>
                  </div>
                </div>
              </div>
           </div>";
}
?>





















