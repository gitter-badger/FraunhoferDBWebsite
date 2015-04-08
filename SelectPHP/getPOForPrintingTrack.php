<?php

include '../connection.php';

$q = mysqli_real_escape_string($link, $_GET['q']);


$topsql ="SELECT p.POID, p.receiving_date, c.cName, p.shipping_date, TIMESTAMPDIFF(DAY, receiving_date, shipping_date), e.ename, p.initial_inspection, p.final_inspection
          FROM Customers c, POS p, Employees e, WorkedOn w
          WHERE c.CID   = p.CID
          AND p.POID    = '$q'
          AND w.POID    = p.POID
          AND e.EID     = w.EID";
$topresult = mysqli_query($link, $topsql);

$sumSql ="SELECT SUM(ROUND(t.tPrice * pot.quantity, 2)) 
          FROM POTools pot, Tools t, POS p
          WHERE pot.POID = '$q'
          AND pot.POID   = p.POID
          AND p.CID      = t.CID
          AND t.TID      = pot.TID";

$sumResult = mysqli_query($link, $sumSql);

$countSql = "SELECT SUM(quantity), MAX(line_item)
             FROM POTools
             WHERE POID = '$q'";
$countresult = mysqli_query($link, $countSql);

while($row = mysqli_fetch_array($topresult)) {
    $POID = $row[0];
    echo "<div class='col-md-12'>".
         "<span class='col-md-3'><strong>Customer : </strong>".$row[2]."</span>".
         "<span class='col-md-3'><strong>Receiving Date : </strong>".$row[1]."</span>".
         "<span class='col-md-3'><strong>Shipping Date : </strong>".$row[3]."</span></div>".
         "<div class='col-md-12'>".
         "<span class='col-md-3'><strong>Turn around time : </strong>".$row[4]." Days</span>".
         "<span class='col-md-3'><strong>Employee: </strong>".$row[5]."</span>";
}
while($row = mysqli_fetch_array($sumResult)){

    echo "<span class='col-md-3'><strong>Overall price : </strong>".$row[0]." $</span></div>";
}
while($row = mysqli_fetch_array($countresult)){

    echo "<div class='col-md-12'><span class='col-md-3'><strong>Number of tools : </strong>".$row[0]."</span>".
         "<span class='col-md-3'><strong>Number of line items : </strong>".$row[1]."</span></div>";
}
$newResult = mysqli_query($link, $topsql);
while($row = mysqli_fetch_array($newResult)){

    echo "<div class='col-md-12'><div class='col-md-6'><strong>PO comment : </strong>".$row[6]."</div>".
         "<div class='col-md-6'><strong>Final inspection : </strong>".$row[7]."</div></div>";
}
         
// -----------------------------------------------------------//


$sql = "SELECT pot.line_item, pot.TID, t.tDiameter, t.tLength, t.double_end ,pot.quantity, r.run_number, rpo.number_of_items, rpo.final_comment
        FROM POS p, Runs r, RunPOS rpo, POTools pot, Tools t
        WHERE p.POID      = rpo.POID
        AND p.POID        = pot.POID
        AND t.CID         = p.CID
        AND t.TID         = pot.TID
        AND p.POID        = r.POID
        AND r.RID         = rpo.RID
        AND rpo.line_item = pot.line_item
        AND p.POID        = '$q'
        GROUP BY rpo.RPOID
        ORDER BY pot.line_item";

$result = mysqli_query($link, $sql);
/*
if($result){
     echo ("Successfull");
} else{
     echo("Input data is fail".mysqli_error($link));
}*/
$runsql ="SELECT r.coating_type, r.run_number, r.ah_pulses, r.RID, r.run_comment
          FROM Runs r
          WHERE r.POID = '$q'
          GROUP BY r.RID;";

$runresult = mysqli_query($link, $runsql);
/*
if($runresult){
     echo ("Successfull");
} else{
     echo("Input data is fail".mysqli_error($link));
}*/
echo "<table>";
   echo         "<tr>".
                "<td>Line#</td>".
                "<td>ToolID</td>".
                "<td>Dia</td>".
                "<td>Len</td>".
                "<td>DblEnd</td>".  
                "<td>Quantity of items on PO</td>".
                "<td>Run Number</td>".
                "<td>#Of items in run</td>".
                "<td>Final Comment</td>".
                "</tr>";
                //filling it with data from POTools

while($row = mysqli_fetch_array($result)) {
   echo
        "<tr>".
        "<td>".$row[0]."</td>".
        "<td>".$row[1]."</td>".
        "<td>".$row[2]."</td>".
        "<td>".$row[3]."</td>".
        "<td>".$row[4]."</td>".
        "<td>".$row[5]."</td>".
        "<td>".$row[6]."</td>".
        "<td>".$row[7]."</td>".
        "<td>".$row[8]."</td>".
        "</tr>";
}
echo "</table></div><div>RUN INFO<table>";
echo "<tr>".
     "<td>"."Coating Type"."</td>".
     "<td>"."Run Number"."</td>".
     "<td>"."Ah/pulses"."</td>".
     "<td>"."run ID"."</td>".
     "<td>"."Comments"."</td>".
     "</tr>";

while($row = mysqli_fetch_array($runresult)){
   echo 
        "<tr>".
        "<td>".$row[0]."</td>".
        "<td>".$row[1]."</td>".
        "<td>".$row[2]."</td>".
        "<td>".$row[3]."</td>".
        "<td>".$row[4]."</td>".
        "</tr>";
}
 mysqli_close($link);
?>
