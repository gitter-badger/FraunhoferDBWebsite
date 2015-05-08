<?php
/*
        This page generates all the info 
        to print the 'Tracking Sheet' after you picked your PO number.
        The user picks the po_number put we are using the ID here 
        so we can access other tables via foreign keys.
        There are some strange usage of <div> in this file
        because its made to look good when printing on A4 sized paper

*/
include '../connection.php';
// poID from the user
$q = mysqli_real_escape_string($link, $_GET['q']);

// all the basic info for the header of the printout. The timestamp is the turnaround time(difference between receive and shipping date)
$topsql ="SELECT p.po_ID, p.receiving_date, c.customer_name, p.shipping_date, TIMESTAMPDIFF(DAY, receiving_date, shipping_date), e.employee_name, p.initial_inspection, p.final_inspection
          FROM customer c, pos p, employee e, employee_pos w
          WHERE c.customer_ID   = p.customer_ID
          AND p.po_ID    = '$q'
          AND w.po_ID    = p.po_ID
          AND e.employee_ID     = w.employee_ID;";
$topresult = mysqli_query($link, $topsql);

// the overall price of the PO
$sumSql ="SELECT SUM(ROUND(l.price * l.quantity, 2)) 
          FROM lineitem l
          WHERE l.po_ID = '$q'";
$sumResult = mysqli_query($link, $sumSql);

// the number of tools and number of lineitems
// we can use MAX here to just pick the highest number.
$countSql = "SELECT SUM(quantity), MAX(line_on_po)
             FROM lineitem l
             WHERE l.po_ID = '$q';";
$countresult = mysqli_query($link, $countSql);
while($row = mysqli_fetch_array($sumResult)){
    $overall_price = $row[0];
}
while($row = mysqli_fetch_array($topresult)) {
    $POID = $row[0];
    echo "<div class='col-xs-12'>".
         "<span class='col-xs-3'><strong>Customer : </strong>".$row[2]."</span>".
         "<span class='col-xs-3'><strong>Receiving Date : </strong>".$row[1]."</span>".
         "<span class='col-xs-3'><strong>Shipping Date : </strong>".$row[3]."</span></div>".
         "<div class='col-xs-12'>".
         "<span class='col-xs-3'><strong>Turn around time : </strong>".$row[4]." Days</span>".
         "<span class='col-xs-3'><strong>Employee: </strong>".$row[5]."</span>".
         "<span class='col-xs-3'><strong>Overall price : </strong>".$overall_price." $</span></div>";
}

while($row = mysqli_fetch_array($countresult)){

    echo "<div class='col-xs-12'><span class='col-xs-3'><strong>Number of tools : </strong>".$row[0]."</span>".
         "<span class='col-xs-3'><strong>Number of line items : </strong>".$row[1]."</span></div>";
}
$newResult = mysqli_query($link, $topsql);
while($row = mysqli_fetch_array($newResult)){

    echo "<div class='col-xs-6'><div class='col-xs-6'><strong>Initial inspection : </strong>".$row[6]."</div>".
         "<div class='col-xs-6'style='margin-bottom:10px;'><strong>Final inspection : </strong>".$row[7]."</div></div>";
}
         

// All the info for the lineitems on this PO
// ordered by what line on the PO they are
$sql = "SELECT l.line_on_po, l.tool_ID, l.diameter, l.length, IF(l.double_end = 0, 'NO', 'YES') AS 'Double End', l.quantity, posr.run_number_on_po, lr.number_of_items_in_run, lr.lineitem_run_comment
        FROM lineitem l, lineitem_run lr, pos_run posr, run r
        WHERE l.po_ID = '$q'
        AND posr.po_ID = l.po_ID
        AND l.lineitem_ID = lr.lineitem_ID
        AND lr.run_ID = r.run_ID
        AND posr.run_ID = r.run_ID
        ORDER BY l.line_on_po;";

$result = mysqli_query($link, $sql);

if(!$result){
     echo("Input data is fail".mysqli_error($link));
}

// All the info about the runs linked to this PO
$runsql ="SELECT c.coating_type, posr.run_number_on_po, r.ah_pulses, r.run_number, r.run_comment
          FROM run r, coating c, lineitem_run lr, lineitem l, pos_run posr
          WHERE l.po_ID = '$q'
          AND lr.lineitem_ID = l.lineitem_ID
          AND lr.run_ID = r.run_ID
          AND posr.po_ID = l.po_ID
          AND posr.run_ID = r.run_ID
          AND r.coating_ID = c.coating_ID
          GROUP BY r.run_ID
          ORDER BY posr.run_number_on_po;";

$runresult = mysqli_query($link, $runsql);

if(!$runresult){
     echo("Input data is fail".mysqli_error($link));
}
   echo "<table>";
   echo "<tr>".
        "<td width='60'>Line#</td>".
        "<td width='120'># of items on PO</td>".
        "<td>ToolID</td>".
        "<td width='50'>Dia</td>".
        "<td width='50'>Len</td>".
        "<td width='50'>DblEnd</td>".  
        "<td width='50'>Run Number</td>".
        "<td width='110'>#Of items in run</td>".
        "<td>Final inspection</td>".
        "</tr>";

while($row = mysqli_fetch_array($result)) {
   echo "<tr>".
        "<td>".$row[0]."</td>".
        "<td>".$row[5]."</td>".
        "<td>".$row[1]."</td>".
        "<td>".$row[2]."</td>".
        "<td>".$row[3]."</td>".
        "<td>".$row[4]."</td>".
        "<td>".$row[6]."</td>".
        "<td>".$row[7]."</td>".
        "<td>".$row[8]."</td>".
        "</tr>";
}
echo "</table></div><div style='margin-top: 10px;'>RUN INFO<table>";
echo "<tr>".
     "<td>"."Coating Type"."</td>".
     "<td>"."Run Number"."</td>".
     "<td>"."Ah/pulses"."</td>".
     "<td>"."run ID"."</td>".
     "<td>"."Comments"."</td>".
     "</tr>";

while($row = mysqli_fetch_array($runresult)){
   echo "<tr>".
        "<td>".$row[0]."</td>".
        "<td>".$row[1]."</td>".
        "<td>".$row[2]."</td>".
        "<td>".$row[3]."</td>".
        "<td>".$row[4]."</td>".
        "</tr>";
}
 mysqli_close($link);
?>
