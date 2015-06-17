<?php

include '../connection.php';

session_start();

$po_ID = $_SESSION["po_ID"];

$sql = "SELECT l.line_on_po, lr.number_of_items_in_run, l.quantity, r.run_number, lr.lineitem_run_comment, lr.lineitem_ID, lr.run_ID 
        FROM lineitem l, lineitem_run lr, run r
        WHERE l.po_ID = '$po_ID'
        AND l.lineitem_ID = lr.lineitem_ID
        AND lr.run_ID = r.run_ID
        ORDER BY l.line_on_po;";

$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($link) . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
$linecounter = 0;
echo"<table><tr>".
    "<td>Line Item#</td>".
    "<td>Number of Tools</td>".                
    "<td>Run number</td>".
    "<td>Final Comment</td>".
    "</tr>";

while($row = mysqli_fetch_array($result)) {
   echo "<tr>".
            "<td><a href='#' data-toggle='modal' data-target='#".$linecounter."'>".$row[0]."</td>".
            "<td>".$row[1]."/".$row[2]."</td>".
            "<td>".$row[3]."</td>".
            "<td>".$row[4]."</td>".
        "</tr>";
}
echo "</table>";
$result = mysqli_query($link, $sql);
while($row = mysqli_fetch_array($result)) {
    echo "<div class='modal fade' id='".$linecounter."' tabindex='-1' role='dialog' aria-labelledby='".$linecounter."' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title' id='myModalLabel'>Lineitem : ".$row[0]." Number of tools : ".$row[1]."</h4>
                  </div>
                  <div class='modal-body'>
                    <h3>Add or edit run comment</h3>
                    <p>This is the current comment</p>
                    <textarea id='new_comment'>".$row[4]."</textarea>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-default' onclick='showRunTools()' data-dismiss='modal'>Close</button>
                    <button type='button' class='btn btn-success' onclick='updateRunToolComment(".$row[5].", ".$row[6].")'data-dismiss='modal'>Save changes</button>
                  </div>
                </div>
              </div>
           </div>";
    $linecounter = $linecounter + 1;
}

?>





















