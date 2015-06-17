<?php

include '../connection.php';
session_start();
$po_ID = $_SESSION['po_ID'];

// display the table
echo "<table><tr>".
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
        AND posr.po_ID = '$po_ID'
        AND r.coating_ID = c.coating_ID
        ORDER BY posr.run_number_on_po";
//run a query to find the right ID of our coating
$result = mysqli_query($link, $sql);


if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}


while($row = mysqli_fetch_array($result)){
    if($row[4] == 1){ $row[4] = a;}
    if($row[4] == 2){ $row[4] = b;}
    if($row[4] == 3){ $row[4] = c;}
    if($row[4] == 4){ $row[4] = d;}
    if($row[4] == 5){ $row[4] = e;}
    if($row[4] == 6){ $row[4] = f;}
    if($row[4] == 7){ $row[4] = g;}
    echo "<tr><td><a href='#' data-toggle='modal' data-target='#".$row[1]."'>".$row[1]."</td>".
         "<td>".$row[2]."</td>". 
         "<td>".$row[3]."</td>".
         "<td>".$row[4]."</td>".
         "<td>".$row[5]."</td>".
         "</tr>";
}
echo "</table>";
$result = mysqli_query($link, $sql);
while($row = mysqli_fetch_array($result)){
    echo "<div class='modal fade' id='".$row[1]."' tabindex='-1' role='dialog' aria-labelledby='".$row[1]."' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>Run number : ".$row[1]."</h4>
                  </div>
                  <div class='modal-body'>
                    <h3>Add or edit run comment</h3>
                    <p>This is the current comment</p>
                    <textarea  class='new_comment'>".$row[5]."</textarea>
                    <button type='button' class='btn btn-default' onclick='showPOTools()' data-dismiss='modal'>Close</button>
                    <button type='button' class='btn btn-success comment_button' data-dismiss='modal' onclick='updateRunComment(".$row[0].")'>Save changes</button>
                  </div>
                  <div class='modal-footer'>
                  </div>
                </div>
              </div>
           </div>";
}
?>















